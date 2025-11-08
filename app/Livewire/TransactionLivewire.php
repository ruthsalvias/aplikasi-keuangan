<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;
use App\Models\TransactionReceipt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TransactionLivewire extends Component 
{
    use WithPagination, WithFileUploads;

    // Component configuration
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search', 'filterType', 'filterDateFrom', 'filterDateTo'];

    // Event listeners
    #[On('modalClosed')]
    public function resetModalStates()
    {
        $this->reset([
            'addTransactionType', 'addAmount', 'addTransactionDate', 
            'addDescription', 'addReceiptFile',
            'editTransactionId', 'editTransactionType', 'editAmount',
            'editTransactionDate', 'editDescription',
            'editCoverTransactionId', 'editCoverTransactionFile', 'oldReceiptPath',
            'deleteTransactionId', 'deleteDescription', 'deleteConfirmDescription',
            'oldReceiptExists',
            'detailTransaction'
        ]);
        
        $this->addTransactionDate = now()->format('Y-m-d');
    }

    #[On('transactionAdded')] 
    public function refreshComponent() 
    {
        // This is intentionally left empty. 
        // Calling this method through an event is enough to trigger a re-render.
    }

    // General properties
    public $auth;
    public $perPage = 20;

    // Search and filter properties
    public $search = '';
    public $filterType = ''; 
    public $filterDateFrom = '';
    public $filterDateTo = '';

    // Add transaction properties
    public $addTransactionType = 'income';
    public $addAmount;
    public $addTransactionDate;
    public $addDescription;
    public $addReceiptFile;
    
    // Detail transaction property
    public $detailTransaction;

    // Edit transaction properties
    public $editTransactionId;
    public $editTransactionType;
    public $editAmount;
    public $editTransactionDate;
    public $editDescription;
    public $editCategoryID;

    // Image management properties
    public $editCoverTransactionId;
    public $editCoverTransactionFile;
    public $oldReceiptPath;
    public $oldReceiptExists = false;

    // Delete transaction properties
    public $deleteTransactionId;
    public $deleteDescription;
    public $deleteConfirmDescription;

    // Validation
    protected function getValidationRules($isEdit = false)
    {
        $rules = [
            ($isEdit ? 'edit' : 'add') . 'TransactionType' => 'required|in:income,expense',
            ($isEdit ? 'edit' : 'add') . 'Amount' => 'required|numeric|min:1',
            ($isEdit ? 'edit' : 'add') . 'TransactionDate' => 'required|date',
            ($isEdit ? 'edit' : 'add') . 'Description' => 'required|string|max:1000',
        ];

        return $rules;
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterType', 'filterDateFrom', 'filterDateTo'])) {
            $this->resetPage();
        }

        $this->validateOnly($propertyName, $this->getValidationRules(Str::startsWith($propertyName, 'edit')));
    }

    public function mount()
    {
        $this->auth = Auth::user();
        $this->addTransactionDate = now()->format('Y-m-d');

        // Check if we should show detail modal on page load
        $action = request()->query('action');
        $id = request()->query('id');
        if ($action === 'detail' && $id) {
            $this->prepareDetailTransaction($id);
        }
    }

    public function updating($property)
    {
        if (in_array($property, ['search', 'filterType', 'filterDateFrom', 'filterDateTo'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        // Guard against missing tables (e.g., before running migrations)
        $hasTransactions = Schema::hasTable('transactions');

        if ($hasTransactions) {
            $query = $this->auth->transactions()
                ->when($this->search, fn($q) => $q->where('description', 'ilike', '%' . $this->search . '%'))
                ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
                ->when($this->filterDateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $this->filterDateFrom))
                ->when($this->filterDateTo, fn($q) => $q->whereDate('transaction_date', '<=', $this->filterDateTo));

            $transactions = $query->latest()->paginate($this->perPage);

            $totalIncome = $this->auth->transactions()->where('type', 'income')->sum('amount');
            $totalExpense = $this->auth->transactions()->where('type', 'expense')->sum('amount');
        } else {
            // If transactions table doesn't exist yet, return empty dataset and zeroed stats
            $transactions = collect();
            $totalIncome = 0;
            $totalExpense = 0;
        }

        $balance = $totalIncome - $totalExpense;

        return view('livewire.transaction-livewire', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance
        ]);
    }

    public function addTransaction()
    {
        $this->resetErrorBag();
    
        try {
            // Validate form fields + optional receipt file
            $rules = $this->getValidationRules();
            $rules['addReceiptFile'] = 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048';
            $this->validate($rules);
    
            DB::beginTransaction();
    
            // Handle file upload if present
            $receiptPath = null;
            if ($this->addReceiptFile) {
                try {
                    $receiptPath = $this->addReceiptFile->store('receipts', 'public');
                } catch (\Exception $e) {
                    throw new \Exception('Gagal menyimpan file bukti transaksi: ' . $e->getMessage());
                }

                // Verify the file really exists on the configured disk. If not, fail early so DB is not updated.
                if (!$receiptPath || !Storage::disk('public')->exists($receiptPath)) {
                    // If a path was returned but file missing, attempt to remove any leftover
                    if ($receiptPath && Storage::disk('public')->exists($receiptPath)) {
                        Storage::disk('public')->delete($receiptPath);
                    }
                    throw new \Exception('Gagal menyimpan file bukti transaksi (verifikasi file gagal).');
                }
            }
    
            // Create transaction
            $transaction = $this->auth->transactions()->create([
                'type' => $this->addTransactionType,
                'amount' => $this->addAmount,
                'transaction_date' => $this->addTransactionDate,
                'description' => $this->addDescription,
                'receipt_image_path' => $receiptPath
            ]);
    
            if (!$transaction) {
                throw new \Exception('Gagal menyimpan transaksi.');
            }

            // If file uploaded, persist a receipt record (normalized table)
            if ($receiptPath) {
                TransactionReceipt::create([
                    'transaction_id' => $transaction->id,
                    'path' => $receiptPath,
                    'uploaded_by' => $this->auth->id,
                ]);
            }
    
            DB::commit();
    
            // Reset pagination to show latest transactions first, then reset form state
            $this->resetPage();
            $this->resetModalStates();
    
            // Trigger UI events (close modal, show alert)
            $this->dispatch('closeModal', id: 'addTransactionModal');
            $this->dispatch('showAlert', type: 'success', message: 'Berhasil menambahkan data');
    
            // Dispatch event so other components can react
            $this->dispatch('transactionAdded');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed, do nothing, Livewire will handle it
            
        } catch (\Exception $e) {
            DB::rollBack();
    
            \Log::error('Add transaction error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Current data state:', [
                'type' => $this->addTransactionType,
                'amount' => $this->addAmount,
                'date' => $this->addTransactionDate,
                'description' => $this->addDescription
            ]);
    
            // Clean up uploaded file if exists
            if (isset($receiptPath) && Storage::disk('public')->exists($receiptPath)) {
                Storage::disk('public')->delete($receiptPath);
            }
    
            $this->dispatch('showAlert', type: 'error', message: 'Gagal menambahkan transaksi: ' . $e->getMessage());
        }
    }

    public function prepareDetailTransaction($transactionId)
    {
        $this->detailTransaction = $this->auth->transactions()->find($transactionId);
        
        if (!$this->detailTransaction) {
            $this->dispatch('showAlert', type: 'error', message: 'Transaksi tidak ditemukan!');
            return;
        }

    $this->dispatch('showModal', id: 'detailTransactionModal');
    }

    public function prepareEditTransaction($transactionId)
    {
        $transaction = $this->auth->transactions()->find($transactionId);
        
        if (!$transaction) {
            $this->dispatch('showAlert', type: 'error', message: 'Transaksi tidak ditemukan!');
            return;
        }

        $this->editTransactionId = $transaction->id;
        $this->editTransactionType = $transaction->type;
        $this->editAmount = $transaction->amount;
        $this->editTransactionDate = $transaction->transaction_date->format('Y-m-d');
        $this->editDescription = $transaction->description;

    $this->dispatch('showModal', id: 'editTransactionModal');
    $this->dispatch('trix-load-edit', content: $this->editDescription);
    }

    public function editTransaction()
    {
        DB::beginTransaction();
    
        try {
            $validatedData = $this->validate($this->getValidationRules(true));
    
            $transaction = $this->auth->transactions()->findOrFail($this->editTransactionId);
    
            $transaction->update([
                'type' => $validatedData['editTransactionType'],
                'amount' => $validatedData['editAmount'],
                'transaction_date' => $validatedData['editTransactionDate'],
                'description' => $validatedData['editDescription']
            ]);
    
            DB::commit();
    
            $this->resetModalStates();
            $this->dispatch('closeModal', id: 'editTransactionModal');
            $this->dispatch('showAlert', type: 'success', message: 'Transaksi berhasil diubah!');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Let Livewire handle validation exceptions
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Edit transaction error: ' . $e->getMessage());
    
            $this->dispatch('showAlert', type: 'error', message: 'Gagal mengubah transaksi: ' . $e->getMessage());
        }
    }

    public function prepareDeleteTransaction($transactionId)
    {
        $transaction = $this->auth->transactions()->find($transactionId);
        
        if (!$transaction) {
            $this->dispatch('showAlert', type: 'error', message: 'Transaksi tidak ditemukan!');
            return;
        }
        
        $this->deleteTransactionId = $transaction->id;
        $this->deleteDescription = strip_tags($transaction->description);
        $this->deleteConfirmDescription = '';
    $this->dispatch('showModal', id: 'deleteTransactionModal');
    }

    public function deleteTransaction()
    {
        if ($this->deleteConfirmDescription !== 'HAPUS') {
            $this->addError('deleteConfirmDescription', 'Konfirmasi tidak sesuai. Ketik HAPUS untuk menghapus.');
            return;
        }

        DB::beginTransaction();

        try {
            $transaction = $this->auth->transactions()->findOrFail($this->deleteTransactionId);
            // Delete associated receipt files stored in transaction_receipts (if any)
            if (method_exists($transaction, 'receipts')) {
                $paths = $transaction->receipts()->pluck('path')->toArray();
                foreach ($paths as $p) {
                    if ($p && Storage::disk('public')->exists($p)) {
                        Storage::disk('public')->delete($p);
                    }
                }
            } else {
                // Fallback to legacy single column
                if ($transaction->receipt_image_path) {
                    Storage::disk('public')->delete($transaction->receipt_image_path);
                }
            }

            $transaction->delete();

            DB::commit();

            $this->resetModalStates();
            $this->dispatch('closeModal', id: 'deleteTransactionModal');
            $this->dispatch('showAlert', type: 'success', message: 'Transaksi berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Delete transaction error: ' . $e->getMessage());
            
            $this->dispatch('showAlert', type: 'error', message: 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function prepareEditCover($transactionId)
    {
        $transaction = $this->auth->transactions()->find($transactionId);
        
        if (!$transaction) {
            $this->dispatch('showAlert', type: 'error', message: 'Transaksi tidak ditemukan!');
            return;
        }

        $this->editCoverTransactionId = $transaction->id;
        // Use latest receipt path if available (normalized receipts table)
        if (method_exists($transaction, 'receipts')) {
            $this->oldReceiptPath = $transaction->receipts()->latest()->value('path');
        } else {
            $this->oldReceiptPath = $transaction->receipt_image_path;
        }

        // Check if the stored file actually exists on the configured 'public' disk
        $this->oldReceiptExists = false;
        if ($this->oldReceiptPath) {
            try {
                $this->oldReceiptExists = Storage::disk('public')->exists($this->oldReceiptPath);
            } catch (\Exception $e) {
                \Log::warning('Could not check receipt existence: ' . $e->getMessage());
                $this->oldReceiptExists = false;
            }
        }
    $this->dispatch('showModal', id: 'editCoverTransactionModal');
    }

    public function editCoverTransaction()
    {
        // Validate the uploaded file first so Livewire can handle validation exceptions
        $this->validate([
            'editCoverTransactionFile' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $transaction = $this->auth->transactions()->findOrFail($this->editCoverTransactionId);

            // Delete previous stored file(s) (latest) if exists
            if (method_exists($transaction, 'receipts')) {
                $oldPath = $transaction->receipts()->latest()->value('path');
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            } else {
                if ($transaction->receipt_image_path && Storage::disk('public')->exists($transaction->receipt_image_path)) {
                    Storage::disk('public')->delete($transaction->receipt_image_path);
                }
            }

            $path = $this->editCoverTransactionFile->store('receipts', 'public');

            if (!$path || !Storage::disk('public')->exists($path)) {
                // try to clean up if something odd happened
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                throw new \Exception('Gagal menyimpan file bukti (verifikasi file gagal).');
            }

            // Create a receipt record (normalized)
            TransactionReceipt::create([
                'transaction_id' => $transaction->id,
                'path' => $path,
                'uploaded_by' => $this->auth->id,
            ]);

            // Also keep legacy column for backward compat if present
            $transaction->update(['receipt_image_path' => $path]);

            DB::commit();

            $this->resetModalStates();
            $this->dispatch('closeModal', id: 'editCoverTransactionModal');
            $this->dispatch('showAlert', type: 'success', message: 'Bukti transaksi berhasil diubah!');
            // Emit an event so the transaction list (and other listeners) refresh
            // Use Livewire v3 dispatch (emit() is v2 and removed)
            $this->dispatch('transactionAdded');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update receipt image error: ' . $e->getMessage());
            
            // Clean up uploaded file if exists
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            $this->dispatch('showAlert', type: 'error', message: 'Gagal mengupload bukti transaksi: ' . $e->getMessage());
        }
    }

    public function updatedEditCoverTransactionFile()
    {
        try {
            $this->validate([
                'editCoverTransactionFile' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048'
            ]);
        } catch (\Exception $e) {
            $this->reset('editCoverTransactionFile');
            $this->dispatch('showAlert', type: 'error', message: 'File tidak valid: ' . $e->getMessage());
        }
    }
}