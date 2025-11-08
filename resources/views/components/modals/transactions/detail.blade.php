{{-- Detail Transaction Modal --}}
<div class="modal fade" id="detailTransactionModal" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                    Detail Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($detailTransaction)
                    {{-- Info Panel --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                {{-- Tipe & Status --}}
                                <span class="badge rounded-pill px-3 py-2" 
                                      style="background: {{ $detailTransaction->type === 'income' ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)' }}; color: white;">
                                    <i class="bi bi-arrow-{{ $detailTransaction->type === 'income' ? 'up' : 'down' }}-circle-fill me-1"></i>
                                    {{ $detailTransaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                                {{-- Tanggal --}}
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    <i class="bi bi-calendar2-week me-1"></i>
                                    {{ $detailTransaction->transaction_date->format('d/m/Y') }}
                                </span>
                            </div>

                            {{-- Jumlah --}}
                            <h3 class="fw-bold mb-0" 
                                style="color: {{ $detailTransaction->type === 'income' ? '#11998e' : '#eb3349' }}">
                                {{ $detailTransaction->type === 'income' ? '+' : '-' }} 
                                Rp {{ number_format($detailTransaction->amount, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-file-text me-2"></i>Deskripsi
                        </h6>
                        <div class="bg-light rounded-4 p-3">
                            {{ nl2br(htmlspecialchars($detailTransaction->description, ENT_QUOTES, 'UTF-8')) }}
                        </div>
                    </div>

                    {{-- Bukti Transaksi --}}
                    @if($detailTransaction->receipt_image_url)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-image me-2"></i>Bukti Transaksi
                            </h6>
                            <div class="rounded-4 overflow-hidden shadow-sm text-center">
                                    {{-- Show image inline; clicking opens the lightbox modal (no new tab) --}}
                                    <img src="{{ $detailTransaction->receipt_image_url }}" 
                                         alt="Bukti Transaksi" 
                                         class="img-fluid w-100 open-image-full"
                                         data-src="{{ $detailTransaction->receipt_image_url }}"
                                         style="cursor: pointer;"
                                         onerror="this.style.opacity=0.6; this.title='Gagal memuat gambar';">
                                    <div class="mt-2 small text-muted">Klik gambar untuk melihat ukuran penuh.</div>
                                </div>
                        </div>
                    @endif

                    {{-- Info Tambahan --}}
                    <div class="bg-light rounded-4 p-3">
                        <div class="row g-3">
                            {{-- Created At --}}
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-white rounded-3 p-2">
                                        <i class="bi bi-clock text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Dibuat</small>
                                        <span class="small fw-semibold">{{ $detailTransaction->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Updated At (if different) --}}
                            @if($detailTransaction->updated_at->ne($detailTransaction->created_at))
                                <div class="col-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-white rounded-3 p-2">
                                            <i class="bi bi-pencil text-warning"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Terakhir Diubah</small>
                                            <span class="small fw-semibold">{{ $detailTransaction->updated_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" 
                                class="btn btn-light fw-semibold rounded-3" 
                                data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <button type="button"
                                wire:click="prepareEditTransaction({{ $detailTransaction->id }})"
                                class="btn btn-warning fw-semibold rounded-3">
                            <i class="bi bi-pencil-fill me-2"></i>Edit
                        </button>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-exclamation-circle text-warning fs-1"></i>
                        </div>
                        <h6>Data tidak ditemukan</h6>
                        <p class="text-muted small mb-0">Transaksi mungkin telah dihapus atau tidak dapat diakses</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>