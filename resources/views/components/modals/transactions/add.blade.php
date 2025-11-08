{{-- Add Transaction Modal --}}
<div class="modal fade" id="addTransactionModal" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle-fill text-primary me-2"></i>
                    Tambah Transaksi Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="addTransaction">
                    {{-- Tipe Transaksi --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tipe Transaksi</label>
                        <div class="btn-group w-100 rounded-3 shadow-sm" role="group">
                            <input type="radio" 
                                   wire:model="addTransactionType" 
                                   class="btn-check" 
                                   name="addTransactionType" 
                                   id="addIncome" 
                                   value="income" 
                                   checked>
                            <label class="btn btn-outline-success" for="addIncome">
                                <i class="bi bi-arrow-up-circle-fill me-2"></i>Pemasukan
                            </label>

                            <input type="radio" 
                                   wire:model="addTransactionType" 
                                   class="btn-check" 
                                   name="addTransactionType" 
                                   id="addExpense" 
                                   value="expense">
                            <label class="btn btn-outline-danger" for="addExpense">
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
                                   wire:model="addAmount" 
                                   class="form-control border-0 shadow-none bg-light"
                                   placeholder="Masukkan jumlah"
                                   min="0"
                                   step="1000">
                        </div>
                        @error('addAmount')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Tanggal --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tanggal Transaksi</label>
                        <input type="date" 
                               wire:model="addTransactionDate" 
                               class="form-control border-0 shadow-none bg-light">
                        @error('addTransactionDate')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea wire:model="addDescription" 
                                  class="form-control border-0 shadow-none bg-light" 
                                  rows="3"
                                  placeholder="Masukkan deskripsi transaksi"></textarea>
                        @error('addDescription')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Upload Bukti (DENGAN PERBAIKAN PRATINJAU) --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Bukti Transaksi (Opsional)</label>
                        <input type="file" 
                               wire:model="addReceiptFile" 
                               class="form-control border-0 shadow-none bg-light"
                               accept="image/*">
                        @error('addReceiptFile')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                        
                        {{-- KODE BARU UNTUK PRATINJAU GAMBAR --}}
                        @if ($addReceiptFile)
                            <div class="mt-3 text-center border p-2 rounded-3">
                                <h6 class="small text-muted mb-2">Pratinjau Gambar:</h6>
                                {{-- Livewire secara otomatis menyediakan temporary URL untuk file yang di-upload --}}
                                <img src="{{ $addReceiptFile->temporaryUrl() }}" 
                                     class="img-fluid rounded-3" 
                                     style="max-height: 200px; object-fit: contain;">
                            </div>
                        @endif
                        {{-- END KODE BARU --}}

                    </div>

                    {{-- Tombol Submit --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" 
                                class="btn btn-light fw-semibold rounded-3" 
                                data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" 
                                class="btn btn-primary fw-semibold rounded-3 px-4">
                            <span wire:loading.remove wire:target="addTransaction">
                                <i class="bi bi-check-circle-fill me-2"></i>Simpan
                            </span>
                            <span wire:loading wire:target="addTransaction">
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