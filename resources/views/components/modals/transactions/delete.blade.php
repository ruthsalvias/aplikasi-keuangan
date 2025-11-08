{{-- Delete Transaction Modal --}}
<div class="modal fade" id="deleteTransactionModal" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Hapus Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
                </div>

                <p class="mb-3">
                    Anda akan menghapus transaksi dengan deskripsi:
                    <br>
                    <strong class="text-danger">{{ $deleteDescription }}</strong>
                </p>

                <div class="mb-3">
                    <label class="form-label">Ketik <strong>HAPUS</strong> untuk melanjutkan:</label>
                    <input type="text" 
                           wire:model="deleteConfirmDescription" 
                           class="form-control border-0 shadow-none bg-light" 
                           placeholder="HAPUS">
                    @error('deleteConfirmDescription')
                        <div class="small text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" 
                            class="btn btn-light fw-semibold rounded-3" 
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button"
                            wire:click="deleteTransaction"
                            class="btn btn-danger fw-semibold rounded-3 px-4">
                        <span wire:loading.remove wire:target="deleteTransaction">
                            <i class="bi bi-trash-fill me-2"></i>Hapus
                        </span>
                        <span wire:loading wire:target="deleteTransaction">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>