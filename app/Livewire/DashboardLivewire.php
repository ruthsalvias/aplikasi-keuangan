<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardLivewire extends Component
{
    protected static string $layout = 'components.layouts.app';
    
    public $auth;
    public $stats = [];
    public $monthly = [];
    public $distribution = [];
    public $transactions = [];
    public $perPage = 5; // Limit to show only 5 recent transactions
    public $detailTransaction; // For showing transaction details

    public function mount()
    {
        $this->auth = Auth::user();
        $this->loadStats();
        $this->generateChartData();
        $this->generateDistributionData();
    }
    
    public function loadStats()
    {
        // Guard against missing tables
        if (!Schema::hasTable('transactions')) {
            $this->stats = [
                'income' => 0,
                'expense' => 0,
                'net' => 0,
                'total' => 0
            ];
            return;
        }

        $currentMonth = now();
        
        $monthlyIncome = $this->auth->transactions()
            ->where('type', 'income')
            ->whereMonth('transaction_date', $currentMonth->month)
            ->whereYear('transaction_date', $currentMonth->year)
            ->sum('amount') ?? 0;
            
        $monthlyExpense = $this->auth->transactions()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth->month)
            ->whereYear('transaction_date', $currentMonth->year)
            ->sum('amount') ?? 0;

        $totalIncome = $this->auth->transactions()
            ->where('type', 'income')
            ->sum('amount') ?? 0;
            
        $totalExpense = $this->auth->transactions()
            ->where('type', 'expense')
            ->sum('amount') ?? 0;
        
        $this->stats = [
            'income' => $monthlyIncome,
            'expense' => $monthlyExpense,
            'net' => $monthlyIncome - $monthlyExpense,
            'total' => $totalIncome - $totalExpense
        ];
    }
    
    public function generateChartData()
    {
        // Guard against missing tables
        if (!Schema::hasTable('transactions')) {
            $this->monthly = [
                'months' => [],
                'income' => [],
                'expense' => [],
            ];
            return;
        }

        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        $months = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 0; $i < 6; $i++) {
            $month = $sixMonthsAgo->copy()->addMonths($i);
            $months[] = $month->format('M');

            $income = $this->auth->transactions()
                ->where('type', 'income')
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->sum('amount');

            $expense = $this->auth->transactions()
                ->where('type', 'expense')
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->sum('amount');

            $incomeData[] = $income;
            $expenseData[] = $expense;
        }

        $this->monthly = [
            'months' => $months,
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }
    
    public function generateDistributionData()
    {
        // Guard against missing tables
            if (!Schema::hasTable('transactions')) {
            $this->distribution = [
                'labels' => [],
                'series' => [],
            ];
            return;
        }

            // Simple distribution data based on transaction types
        $this->distribution = [
                'labels' => ['Income', 'Expense'],
                'series' => [
                    $this->stats['income'] ?? 0,
                    $this->stats['expense'] ?? 0
                ],
        ];
    }

    public function showTransactionDetail($transactionId)
    {
        $this->detailTransaction = $this->auth->transactions()->find($transactionId);
        
        if (!$this->detailTransaction) {
            $this->dispatch('showAlert', type: 'error', message: 'Transaksi tidak ditemukan!');
            return;
        }

        $this->dispatch('showModal', id: 'detailTransactionModal');
    }

    public function render()
    {
        // Get the latest transactions
        if (Schema::hasTable('transactions')) {
            $this->transactions = $this->auth->transactions()
                ->latest() // Uses created_at by default
                ->latest('transaction_date') // Secondary sort by transaction_date
                ->take($this->perPage)
                ->get();
        } else {
            $this->transactions = collect();
        }

        return view('livewire.dashboard-livewire', [
            'stats' => [
                'income' => number_format($this->stats['income'] ?? 0, 0, ',', '.'),
                'expense' => number_format($this->stats['expense'] ?? 0, 0, ',', '.'),
                'net' => number_format($this->stats['net'] ?? 0, 0, ',', '.'),
                'total' => number_format($this->stats['total'] ?? 0, 0, ',', '.'),
            ],
            'monthly' => $this->monthly,
            'distribution' => $this->distribution,
            'transactions' => $this->transactions,
        ]);
    }
}