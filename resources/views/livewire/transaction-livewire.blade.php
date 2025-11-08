<div class="pt-4">
    
    {{-- Modern header with gradient --}}
    <div class="card border-0 shadow-lg mb-4 overflow-hidden">
        <div class="card-header border-0 position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-4 p-3 backdrop-blur">
                        <i class="bi bi-wallet2 fs-3 text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold text-white">Catatan Keuangan</h3>
                        <p class="mb-0 text-white-50 small">Kelola transaksi keuangan Anda dengan mudah</p>
                    </div>
                </div>
                <button class="btn btn-light btn-lg shadow-sm fw-semibold rounded-pill px-4" 
                        data-bs-toggle="modal" 
                        data-bs-target="#addTransactionModal"
                        style="transition: all 0.3s ease;">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Transaksi
                </button>
            </div>
        </div>
        
        <div class="card-body p-4">
            
            {{-- Modern filter section --}}
            <div class="bg-light bg-gradient rounded-4 p-4 mb-4 shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-funnel-fill text-primary"></i>
                    </div>
                    <h5 class="mb-0 fw-bold text-dark">Filter & Pencarian</h5>
                </div>
                
                <div class="row g-3">
                    
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-semibold text-secondary mb-2">
                            <i class="bi bi-search me-1"></i> Cari Deskripsi
                        </label>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               class="form-control rounded-pill border-0 shadow-sm" 
                               placeholder="Ketik untuk mencari..."
                               style="background: white;">
                    </div>
                    
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-secondary mb-2">
                            <i class="bi bi-funnel me-1"></i> Tipe
                        </label>
                        <select wire:model.live="filterType" 
                                class="form-select rounded-pill border-0 shadow-sm"
                                style="background: white;">
                            <option value="">Semua Tipe</option>
                            <option value="income"><i class="bi bi-arrow-up-circle-fill me-1"></i> Pemasukan</option>
                            <option value="expense"><i class="bi bi-arrow-down-circle-fill me-1"></i> Pengeluaran</option>
                        </select>
                    </div>
                    

                    
                    <div class="col-lg-1.5 col-md-3 col-6">
                        <label class="form-label small fw-semibold text-secondary mb-2">
                            <i class="bi bi-calendar-event me-1"></i> Dari
                        </label>
                        <input type="date" 
                               wire:model.live="filterDateFrom" 
                               class="form-control rounded-pill border-0 shadow-sm"
                               style="background: white;">
                    </div>
                    
                    <div class="col-lg-1.5 col-md-3 col-6">
                        <label class="form-label small fw-semibold text-secondary mb-2">
                            <i class="bi bi-calendar-check me-1"></i> Sampai
                        </label>
                        <input type="date" 
                               wire:model.live="filterDateTo" 
                               class="form-control rounded-pill border-0 shadow-sm"
                               style="background: white;">
                    </div>
                </div>
            </div>

            {{-- Modern table with cards on mobile --}}
            <div class="table-responsive rounded-4 shadow-sm" style="background: white;">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);">
                        <tr>
                            <th class="fw-bold text-dark border-0 py-3" style="width: 50px;">#</th>
                            <th class="fw-bold text-dark border-0 py-3">
                                <i class="bi bi-calendar3 me-1"></i> Tanggal
                            </th>
                            <th class="fw-bold text-dark border-0 py-3">
                                <i class="bi bi-file-text me-1"></i> Deskripsi
                            </th>

                            <th class="text-center fw-bold text-dark border-0 py-3">
                                <i class="bi bi-arrow-left-right me-1"></i> Tipe
                            </th>
                            <th class="text-end fw-bold text-dark border-0 py-3">
                                <i class="bi bi-cash-stack me-1"></i> Jumlah
                            </th>
                            <th class="text-center fw-bold text-dark border-0 py-3" style="width: 160px;">
                                <i class="bi bi-gear me-1"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr wire:key="transaction-{{ $transaction->id }}" 
                                class="border-bottom"
                                style="transition: all 0.3s ease;">
                                <td class="py-3">
                                    <span class="badge bg-light text-dark rounded-circle" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="text-nowrap py-3">
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                        <i class="bi bi-calendar2-week me-1"></i>
                                        {{ $transaction->transaction_date->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 280px;">
                                        {{ Str::limit(strip_tags($transaction->description), 50) }}
                                    </div>
                                </td>

                                <td class="text-center py-3">
                                    @if ($transaction->type === 'income')
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm" 
                                              style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                            <i class="bi bi-arrow-up-circle-fill me-1"></i> Pemasukan
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm" 
                                              style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); color: white;">
                                            <i class="bi bi-arrow-down-circle-fill me-1"></i> Pengeluaran
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold py-3 text-nowrap" 
                                    style="font-size: 1.05rem; color: {{ $transaction->type === 'income' ? '#38ef7d' : '#f45c43' }};">
                                    {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-center text-nowrap py-3">
                                    <div class="btn-group shadow-sm rounded-pill" role="group">
                                        
                                        {{-- Tombol Edit --}}
                                        <button 
                                            type="button"
                                            wire:click="prepareEditTransaction({{ $transaction->id }})" 
                                            class="btn btn-sm position-relative border-0" 
                                            style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white;"
                                            title="Edit Transaksi">
                                            <i class="bi bi-pencil-fill"></i>
                                            <span wire:loading wire:target="prepareEditTransaction({{ $transaction->id }})" 
                                                  class="spinner-border spinner-border-sm position-absolute top-50 start-50 translate-middle" 
                                                  role="status">
                                            </span>
                                        </button>
                                        
                                        {{-- Tombol Bukti --}}
                                        <button 
                                            type="button"
                                            wire:click="prepareEditCover({{ $transaction->id }})" 
                                            class="btn btn-sm position-relative border-0"
                                            style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333;"
                                            title="Kelola Bukti Transaksi">
                                            @if ($transaction->receipt_image_url)
                                                <i class="bi bi-image-fill"></i>
                                            @else
                                                <i class="bi bi-image"></i>
                                            @endif
                                            <span wire:loading wire:target="prepareEditCover({{ $transaction->id }})" 
                                                  class="spinner-border spinner-border-sm position-absolute top-50 start-50 translate-middle" 
                                                  role="status">
                                            </span>
                                        </button>

                                        {{-- Tombol Detail --}}
                                        <button 
                                            type="button"
                                            wire:click="prepareDetailTransaction({{ $transaction->id }})"
                                            class="btn btn-sm position-relative border-0"
                                            style="background: linear-gradient(135deg, #52A5E9 0%, #337AB7 100%); color: white;"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        
                                        {{-- Tombol Hapus --}}
                                        <button 
                                            type="button"
                                            wire:click="prepareDeleteTransaction({{ $transaction->id }})" 
                                            class="btn btn-sm position-relative border-0"
                                            style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); color: white;"
                                            title="Hapus Transaksi">
                                            <i class="bi bi-trash-fill"></i>
                                            <span wire:loading wire:target="prepareDeleteTransaction({{ $transaction->id }})" 
                                                  class="spinner-border spinner-border-sm position-absolute top-50 start-50 translate-middle" 
                                                  role="status">
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div class="bg-light rounded-circle p-4">
                                            <i class="bi bi-inbox fs-1 text-muted"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted mb-1">Tidak Ada Data</h5>
                                            <p class="text-muted small mb-0">Tidak ada transaksi yang cocok dengan filter Anda</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Modern pagination --}}
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
            
        </div>
    </div>

    {{-- Modals --}}
    @include('components.modals.transactions.add')
    @include('components.modals.transactions.edit')
    @include('components.modals.transactions.delete')
    @include('components.modals.transactions.edit-cover')
    @include('components.modals.transactions.detail')
    
    {{-- Lightbox modal for viewing full-size receipt images --}}
    <div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <button type="button" class="btn-close position-absolute end-0 m-3 bg-white rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img id="imageLightboxImg" src="" alt="Foto Bukti" class="img-fluid rounded shadow" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>
    
    {{-- SCRIPT UNTUK LIVEWIRE V3 --}}
    @script
    <script>
        console.log('Livewire Transaction Script Loaded');
        
        // Inisialisasi tooltip
        function initTooltips() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => {
                // Dispose existing tooltip first
                const existingTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                if (existingTooltip) {
                    existingTooltip.dispose();
                }
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        initTooltips();

        // Re-init tooltip setelah Livewire update
        Livewire.hook('morph.updated', () => {
            initTooltips();
        });

        // Initialize Bootstrap Modals
        document.querySelectorAll('.modal').forEach(modal => {
            // Reset modal state on hidden
            modal.addEventListener('hidden.bs.modal', () => {
                $wire.dispatch('modalClosed');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
                document.body.classList.remove('modal-open');
            });
        });

        // Clean up any stuck backdrops when page loads
        document.addEventListener('DOMContentLoaded', () => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
            document.body.classList.remove('modal-open');
        });

        // Handle modal events
        Livewire.on("showModal", event => {
            const modalId = event?.id || event[0]?.id;
            if (modalId) {
                const modalEl = document.getElementById(modalId);
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            }
        });

        Livewire.on("closeModal", event => {
            const modalId = event?.id || event[0]?.id;
            if (modalId) {
                const modalEl = document.getElementById(modalId);
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                        modal.hide();
                    }
                }
            }
        });

        $wire.on('trix-load-edit', (event) => {
            console.log('Trix load edit event received:', event);
            const content = event[0]?.content || event.content;
            const trixEditor = document.querySelector("#editTransactionModal trix-editor");
            if (trixEditor && trixEditor.editor) {
                trixEditor.editor.loadHTML(content);
            }
        });

        $wire.on('showAlert', (event) => {
            console.log('Show alert event received:', event);
            const message = event[0]?.message || event.message;
            const icon = event[0]?.icon || event.icon || 'info';
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: icon,
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                alert(message);
            }
        });

        // Hover effect for table rows
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                if (!row.querySelector('.text-center.py-5')) {
                    row.addEventListener('mouseenter', function() {
                        this.style.backgroundColor = '#f8f9ff';
                        this.style.transform = 'scale(1.01)';
                    });
                    row.addEventListener('mouseleave', function() {
                        this.style.backgroundColor = '';
                        this.style.transform = '';
                    });
                }
            });
        });

        // Button hover effects
        const style = document.createElement('style');
        document.head.appendChild(style);

        // Lightbox: open full-size image in modal when overlay clicked
        document.addEventListener('click', function (e) {
            const target = e.target.closest('.open-image-full');
            if (!target) return;
            e.preventDefault();
            const src = target.getAttribute('data-src') || target.getAttribute('href');
            if (!src) return;
            const img = document.getElementById('imageLightboxImg');
            img.src = src;
            const modalEl = document.getElementById('imageLightboxModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });
    </script>
    @endscript
</div>