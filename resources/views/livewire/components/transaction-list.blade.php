{{-- Transaction List Component --}}
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center" style="width: 80px">#</th>
                <th style="width: 100px">Bukti</th>
                <th>Deskripsi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-end">Jumlah</th>
                <th class="text-center" style="width: 150px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td class="text-center">
                        @if($transaction->type === 'income')
                            <span class="badge bg-success">
                                <i class="bi bi-arrow-down-circle"></i>
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-arrow-up-circle"></i>
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($transaction->receipt_image_url)
                            <div class="position-relative d-inline-block">
                                <img src="{{ $transaction->receipt_image_url }}"
                                     alt="Bukti"
                                     class="img-thumbnail"
                                     style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                     wire:click="prepareDetailTransaction({{ $transaction->id }})"
                                     onerror="this.style.opacity=0.6; this.title='Gagal memuat gambar';">
                                {{-- Small overlay icon to open full image in new tab --}}
                                <a href="{{ $transaction->receipt_image_url }}" target="_blank" rel="noopener" class="position-absolute top-0 end-0 p-1 open-image-full" data-src="{{ $transaction->receipt_image_url }}">
                                    <i class="bi bi-box-arrow-up-right small text-white bg-dark bg-opacity-50 rounded-circle p-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="text-center">
                                <button type="button" class="btn p-0 border-0 bg-transparent" 
                                        wire:click="prepareEditCover({{ $transaction->id }})"
                                        title="Upload Bukti"
                                        style="width:60px; height:60px; display:inline-flex; align-items:center; justify-content:center; background:#f8f9fb; border-radius:6px;">
                                    {{-- inline SVG placeholder to avoid adding image assets --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <path d="M8 14l2-2 3 3 4-5 3 4"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-medium text-truncate" style="max-width: 300px;">
                            {!! strip_tags($transaction->description) !!}
                        </div>
                    </td>
                    <td class="text-center">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                    <td class="text-end">
                        <span class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            {{-- Detail Button --}}
                            <button type="button" 
                                    class="btn btn-info" 
                                    title="Detail"
                                    wire:click="prepareDetailTransaction({{ $transaction->id }})">
                                <i class="bi bi-eye"></i>
                            </button>
                            
                            {{-- Edit Button --}}
                            <button type="button" 
                                    class="btn btn-primary" 
                                    title="Edit"
                                    wire:click="prepareEditTransaction({{ $transaction->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            
                            {{-- Delete Button --}}
                            <button type="button" 
                                    class="btn btn-danger" 
                                    title="Hapus"
                                    wire:click="prepareDeleteTransaction({{ $transaction->id }})">
                                <i class="bi bi-trash"></i>
                            </button>

                            {{-- Upload Receipt Button (if no receipt) --}}
                            @if(!$transaction->receipt_image_path)
                                <button type="button" 
                                        class="btn btn-success" 
                                        title="Upload Bukti"
                                        wire:click="prepareEditCover({{ $transaction->id }})">
                                    <i class="bi bi-upload"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada transaksi
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-between align-items-center">
    <div>
        Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} 
        dari {{ $transactions->total() }} data
    </div>
    {{ $transactions->links() }}
</div>