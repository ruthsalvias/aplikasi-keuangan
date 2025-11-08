{{-- Edit Transaction Modal --}}
<div class="modal fade" id="editTransactionModal" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-fill text-warning me-2"></i>
                    Edit Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="editTransaction">
                    {{-- Tipe Transaksi --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tipe Transaksi</label>
                        <div class="btn-group w-100 rounded-3 shadow-sm" role="group">
                            <input type="radio" 
                                   wire:model="editTransactionType" 
                                   class="btn-check" 
                                   name="editTransactionType" 
                                   id="editIncome" 
                                   value="income">
                            <label class="btn btn-outline-success" for="editIncome">
                                <i class="bi bi-arrow-up-circle-fill me-2"></i>Pemasukan
                            </label>

                            <input type="radio" 
                                   wire:model="editTransactionType" 
                                   class="btn-check" 
                                   name="editTransactionType" 
                                   id="editExpense" 
                                   value="expense">
                            <label class="btn btn-outline-danger" for="editExpense">
                                <i class="bi bi-arrow-down-circle-fill me-2"></i>Pengeluaran
                            </label>
                        </div>
                    </div>
                    
                    {{-- Jumlah --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Jumlah (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">Rp</span>
                            <input type="number" 
                                   wire:model="editAmount" 
                                   class="form-control border-0 shadow-none bg-light"
                                   placeholder="Masukkan jumlah"
                                   min="0"
                                   step="1000">
                        </div>
                        @error('editAmount')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Tanggal --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tanggal Transaksi</label>
                        <input type="date" 
                               wire:model="editTransactionDate" 
                               class="form-control border-0 shadow-none bg-light">
                        @error('editTransactionDate')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea wire:model="editDescription" 
                                 class="form-control border-0 shadow-none bg-light" 
                                 rows="3"
                                 placeholder="Masukkan deskripsi transaksi"></textarea>
                        @error('editDescription')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" 
                                class="btn btn-light fw-semibold rounded-3" 
                                data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" 
                                class="btn btn-warning fw-semibold rounded-3 px-4">
                            <span wire:loading.remove wire:target="editTransaction">
                                <i class="bi bi-check-circle-fill me-2"></i>Update
                            </span>
                            <span wire:loading wire:target="editTransaction">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>