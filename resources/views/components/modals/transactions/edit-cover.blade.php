{{-- Edit Cover Transaction Modal --}}
<div class="modal fade" id="editCoverTransactionModal" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-image me-2 text-info"></i>
                    Upload Bukti Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="editCoverTransaction">
                    {{-- Preview Gambar Lama --}}
                    @if($oldReceiptPath)
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Bukti Transaksi Saat Ini</label>
                            @if($oldReceiptExists)
                                <div class="rounded-4 overflow-hidden shadow-sm">
                                    <a href="{{ asset('storage/' . $oldReceiptPath) }}" target="_blank" rel="noopener">
                                        <img src="{{ asset('storage/' . $oldReceiptPath) }}" 
                                             alt="Bukti Transaksi" 
                                             class="img-fluid w-100">
                                    </a>
                                </div>
                                <div class="small text-muted mt-2">Klik gambar untuk membuka ukuran penuh di tab baru.</div>
                            @else
                                <div class="border rounded-4 p-3 bg-light text-center">
                                    <div class="mb-2">
                                        <i class="bi bi-exclamation-circle text-warning fs-2"></i>
                                    </div>
                                    <div class="fw-semibold">Bukti tidak tersedia</div>
                                    <div class="small text-muted">File bukti yang tercatat tidak ditemukan di penyimpanan.</div>
                                </div>
                                <div class="small text-muted mt-2">Jika Anda memiliki file bukti, unggah file baru di bawah ini.</div>
                            @endif
                        </div>
                    @endif
                    
                    {{-- Upload File Baru --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Upload Bukti Transaksi Baru</label>
                        <input type="file" 
                               wire:model="editCoverTransactionFile" 
                               class="form-control border-0 shadow-none bg-light"
                               accept="image/*">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Format yang didukung: JPEG, PNG, GIF, WEBP (maks. 2MB)
                        </div>
                        @error('editCoverTransactionFile')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview File Baru --}}
                    @if($editCoverTransactionFile)
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Preview</label>
                            <div class="rounded-4 overflow-hidden shadow-sm">
                                <img src="{{ $editCoverTransactionFile->temporaryUrl() }}" 
                                     alt="Preview" 
                                     class="img-fluid w-100">
                            </div>
                        </div>
                    @endif

                    {{-- Tombol Submit --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" 
                                class="btn btn-light fw-semibold rounded-3" 
                                data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" 
                                class="btn btn-info text-white fw-semibold rounded-3 px-4"
                                @if(!$editCoverTransactionFile) disabled @endif>
                            <span wire:loading.remove wire:target="editCoverTransaction">
                                <i class="bi bi-cloud-upload-fill me-2"></i>Upload
                            </span>
                            <span wire:loading wire:target="editCoverTransaction">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                Mengupload...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>