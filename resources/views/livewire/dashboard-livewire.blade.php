<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    * { font-family: 'Inter', sans-serif !important; }
    
    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .premium-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }
    
    [data-bs-theme="dark"] .premium-card {
        background: rgba(26, 29, 32, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .premium-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        background-size: 200% 200%;
        animation: gradient-shift 3s ease infinite;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .premium-card:hover::before { opacity: 1; }
    
    .premium-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .stat-icon-wrapper::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: rotate(45deg) translateY(-100%);
        transition: transform 0.6s;
    }
    
    .premium-card:hover .stat-icon-wrapper::before {
        transform: rotate(45deg) translateY(100%);
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    [data-bs-theme="dark"] .chart-card {
        background: rgba(26, 29, 32, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .chart-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.12);
    }
    
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background-size: 200% 200%;
        animation: gradient-shift 8s ease infinite;
        border-radius: 24px;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .metric-badge {
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .action-btn {
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }
    
    .chart-toolbar {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 12px 16px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    [data-bs-theme="dark"] .chart-toolbar {
        background: rgba(26, 29, 32, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .period-btn {
        padding: 8px 18px;
        border-radius: 10px;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s;
    }
    
    .period-btn.active {
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    [data-bs-theme="dark"] .period-btn.active {
        background: rgba(255,255,255,0.1);
    }
    
    .icon-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        background: transparent;
    }
    
    .icon-btn:hover {
        background: rgba(0,0,0,0.05);
        transform: scale(1.1);
    }
    
    [data-bs-theme="dark"] .icon-btn:hover {
        background: rgba(255,255,255,0.1);
    }
    
    .slide-up {
        animation: slide-up 0.6s ease-out forwards;
    }
    
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(102, 126, 234, 0.2);
        border-top-color: #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
</style>

<div class="pt-3">
    {{-- Header Section with Add Transaction Button --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 slide-up">
        <div>
            <h1 class="h2 fw-bold mb-2">
                <span class="gradient-text">Dashboard Keuangan</span>
            </h1>
            <p class="text-muted mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-calendar-check"></i>
                {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('app.transactions') }}" class="action-btn btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                <i class="bi bi-plus-circle me-2"></i>Tambah Transaksi
            </a>
            <button class="action-btn btn btn-light border" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise me-2"></i>
                Refresh
            </button>
            <div class="dropdown">
                <button class="action-btn btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                    <li><a class="dropdown-item" href="#" onclick="window.print()"><i class="bi bi-printer me-2"></i>Cetak</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportData()"><i class="bi bi-download me-2"></i>Export</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Welcome Banner --}}
    <div class="welcome-banner p-4 mb-4 slide-up" style="animation-delay: 0.1s">
        <div class="position-relative" style="z-index: 1;">
            <div class="d-flex align-items-center gap-4">
                <div class="d-none d-md-block">
                    <div class="rounded-circle bg-white bg-opacity-20 p-2" 
                         style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        <div class="position-relative" style="width: 100%; height: 100%;">
                            @php
                                $name = $auth->name;
                                $initials = collect(explode(' ', $name))->map(function($word) {
                                    return strtoupper(substr($word, 0, 1));
                                })->take(2)->join('');
                                $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEEAD', '#D4A5A5', '#9B59B6', '#3498DB'];
                                $colorIndex = abs(crc32($name)) % count($colors);
                                $bgColor = $colors[$colorIndex];
                            @endphp
                            
                            <div class="rounded-circle w-100 h-100 d-flex align-items-center justify-content-center"
                                 style="background: {{ $bgColor }}; font-size: 1.8rem; font-weight: 600; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                                {{ $initials }}
                            </div>
                            <div class="position-absolute" style="bottom: -2px; right: -2px; background: #22c55e; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white;">
                                <i class="bi bi-check-lg text-white" style="font-size: 0.8rem; margin-left: 2px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-white">
                    <h3 class="fw-bold mb-2">Selamat datang, {{ $auth->name }}! 👋</h3>
                    <p class="mb-3 opacity-90">Mari kelola keuangan Anda dengan lebih bijak</p>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="metric-badge bg-white bg-opacity-20 text-white">
                            <i class="bi bi-wallet2"></i>
                            {{ number_format(array_sum($monthly['income'] ?? []), 0, ',', '.') }} transaksi
                        </span>
                        <span class="metric-badge bg-white bg-opacity-20 text-white">
                            <i class="bi bi-tags"></i>
                            {{ count($distribution['labels'] ?? []) }} kategori
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        {{-- Income Card --}}
        <div class="col-sm-6 col-lg-3">
            <div class="premium-card p-4 h-100 slide-up" style="animation-delay: 0.2s">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="stat-icon-wrapper" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="bi bi-arrow-up-circle-fill text-white fs-3"></i>
                    </div>
                    <div class="metric-badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="bi bi-graph-up-arrow"></i>
                        11%
                    </div>
                </div>
                <p class="text-muted small mb-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Pemasukan</p>
                <h2 class="stats-number text-success mb-0">Rp {{ $stats['income'] }}</h2>
                <p class="text-muted small mt-2 mb-0">Bulan ini</p>
            </div>
        </div>

        {{-- Expense Card --}}
        <div class="col-sm-6 col-lg-3">
            <div class="premium-card p-4 h-100 slide-up" style="animation-delay: 0.3s">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="stat-icon-wrapper" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="bi bi-arrow-down-circle-fill text-white fs-3"></i>
                    </div>
                    <div class="metric-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="bi bi-graph-down-arrow"></i>
                        8%
                    </div>
                </div>
                <p class="text-muted small mb-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Pengeluaran</p>
                <h2 class="stats-number text-danger mb-0">Rp {{ $stats['expense'] }}</h2>
                <p class="text-muted small mt-2 mb-0">Bulan ini</p>
            </div>
        </div>

        {{-- Net Balance Card --}}
        <div class="col-sm-6 col-lg-3">
            <div class="premium-card p-4 h-100 slide-up" style="animation-delay: 0.4s">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="stat-icon-wrapper" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="bi bi-wallet2 text-white fs-3"></i>
                    </div>
                    <div class="metric-badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                        <i class="bi bi-check-circle"></i>
                        100%
                    </div>
                </div>
                <p class="text-muted small mb-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Saldo Bersih</p>
                <h2 class="stats-number text-primary mb-0">Rp {{ $stats['net'] }}</h2>
                <p class="text-muted small mt-2 mb-0">Periode ini</p>
            </div>
        </div>

        {{-- Total Balance Card --}}
        <div class="col-sm-6 col-lg-3">
            <div class="premium-card p-4 h-100 slide-up" style="animation-delay: 0.5s">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="stat-icon-wrapper" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="bi bi-piggy-bank-fill text-white fs-3"></i>
                    </div>
                    <div class="metric-badge" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                        <i class="bi bi-infinity"></i>
                    </div>
                </div>
                <p class="text-muted small mb-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Total Saldo</p>
                <h2 class="stats-number" style="color: #8b5cf6;">Rp {{ $stats['total'] }}</h2>
                <p class="text-muted small mt-2 mb-0">Akumulasi</p>
            </div>
        </div>
    </div>

    {{-- Chart Toolbar --}}
    <div class="chart-toolbar mb-3 slide-up" style="animation-delay: 0.6s">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex gap-2">
                <button class="period-btn active" data-period="6">6 Bulan</button>
                <button class="period-btn" data-period="12">1 Tahun</button>
                <button class="period-btn" data-period="all">Semua</button>
            </div>
            <div class="d-flex gap-2">
                <button class="icon-btn" onclick="toggleChartType('line')" title="Line Chart">
                    <i class="bi bi-graph-up"></i>
                </button>
                <button class="icon-btn" onclick="toggleChartType('bar')" title="Bar Chart">
                    <i class="bi bi-bar-chart-fill"></i>
                </button>
                <button class="icon-btn" onclick="toggleChartType('area')" title="Area Chart">
                    <i class="bi bi-activity"></i>
                </button>
                <button class="icon-btn" onclick="downloadChart()" title="Download">
                    <i class="bi bi-download"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row g-4">
        {{-- Trend Chart --}}
        <div class="col-12">
            <div class="chart-card p-4 slide-up" style="animation-delay: 0.7s">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Tren Keuangan</h5>
                        <p class="text-muted small mb-0">Perbandingan pemasukan & pengeluaran</p>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 12px; height: 12px; border-radius: 3px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                            <small class="text-muted">Pemasukan</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 12px; height: 12px; border-radius: 3px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></div>
                            <small class="text-muted">Pengeluaran</small>
                        </div>
                    </div>
                </div>
                <div id="trend-chart" style="height: 350px;"></div>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="premium-card p-4 slide-up" style="animation-delay: 0.9s;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Transaksi Terbaru</h5>
                        <p class="text-muted small mb-0">{{ count($transactions) }} transaksi terakhir</p>
                    </div>
                    <a href="{{ route('app.transactions') }}" class="btn btn-link text-decoration-none">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Tipe</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-center">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                                    <td>{{ Str::limit(strip_tags($transaction->description), 50) }}</td>
                                    <td>
                                        <span class="badge {{ $transaction->type === 'income' ? 'text-bg-success' : 'text-bg-danger' }}">
                                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('app.transactions', ['action' => 'detail', 'id' => $transaction->id]) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            @if($transaction->receipt_image_path)
                                                <i class="bi bi-file-earmark-image"></i>
                                            @else
                                                <i class="bi bi-eye"></i>
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Transaction Detail Modal --}}
    <div class="modal fade" id="detailTransactionModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($detailTransaction)
                        <div class="row g-4">
                            {{-- Transaction Info --}}
                            <div class="col-md-7">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge {{ $detailTransaction->type === 'income' ? 'text-bg-success' : 'text-bg-danger' }} px-3 py-2">
                                        {{ $detailTransaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                    <span class="text-muted">·</span>
                                    <span class="text-muted">
                                        {{ $detailTransaction->transaction_date->format('d M Y') }}
                                    </span>
                                </div>
                                
                                <h4 class="mb-3">
                                    Rp {{ number_format($detailTransaction->amount, 0, ',', '.') }}
                                </h4>
                                
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Deskripsi:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        {!! $detailTransaction->description !!}
                                    </div>
                                </div>
                            </div>

                            {{-- Receipt Image --}}
                            <div class="col-md-5">
                                @if($detailTransaction->receipt_image_path)
                                    <div class="text-center">
                                        <h6 class="text-muted mb-3">Bukti Transaksi:</h6>
                                        <img src="{{ Storage::disk('public')->url($detailTransaction->receipt_image_path) }}" 
                                             class="img-fluid rounded shadow-sm" 
                                             style="max-height: 300px"
                                             alt="Bukti transaksi">
                                        <div class="mt-3">
                                            <a href="{{ Storage::disk('public')->url($detailTransaction->receipt_image_path) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-image fs-1"></i>
                                        <p class="mt-2">Tidak ada bukti transaksi</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- End of content --}}

    {{-- ApexCharts --}}
    <script>
        (function() {
            let trendChart = null;
            let donutChart = null;
            let currentType = 'line';
            
            function waitForApexCharts(callback) {
                if (typeof ApexCharts !== 'undefined') {
                    callback();
                } else {
                    setTimeout(() => waitForApexCharts(callback), 100);
                }
            }
            
            function initCharts() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                
                // Trend Chart Options
                const trendOptions = {
                    series: [{
                        name: 'Pemasukan',
                        data: {!! json_encode($monthly['income'] ?? [1000, 1200, 1500, 1300, 1800, 2000]) !!}
                    }, {
                        name: 'Pengeluaran',
                        data: {!! json_encode($monthly['expense'] ?? [800, 900, 1000, 1100, 1200, 1300]) !!}
                    }],
                    chart: {
                        type: currentType,
                        height: 350,
                        toolbar: { show: false },
                        background: 'transparent',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    colors: ['#667eea', '#f5576c'],
                    stroke: { curve: 'smooth', width: 3 },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.2
                        }
                    },
                    dataLabels: { enabled: false },
                    markers: { size: 5 },
                    xaxis: {
                        categories: {!! json_encode($monthly['months'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                        labels: { style: { colors: isDark ? '#9ca3af' : '#6b7280' } }
                    },
                    yaxis: {
                        labels: {
                            style: { colors: isDark ? '#9ca3af' : '#6b7280' },
                            formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                        }
                    },
                    grid: {
                        borderColor: isDark ? '#374151' : '#e5e7eb',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: { formatter: val => 'Rp ' + val.toLocaleString('id-ID') }
                    }
                };

                // Render trend chart
                const trendEl = document.getElementById('trend-chart');
                
                if (trendEl && !trendChart) {
                    trendChart = new ApexCharts(trendEl, trendOptions);
                    trendChart.render();
                }
            }

            window.toggleChartType = function(type) {
                if (!trendChart || currentType === type) return;
                currentType = type;
                trendChart.updateOptions({ chart: { type: type } });
            };

            window.downloadChart = function() {
                if (trendChart) {
                    trendChart.dataURI().then(({ imgURI }) => {
                        const link = document.createElement('a');
                        link.href = imgURI;
                        link.download = 'chart.png';
                        link.click();
                    });
                }
            };

            window.exportData = function() {
                alert('Export feature coming soon!');
            };

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    waitForApexCharts(initCharts);
                });
            } else {
                waitForApexCharts(initCharts);
            }

            // Period buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('period-btn')) {
                    document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
                    e.target.classList.add('active');
                }
            });
        })();
    </script>
</div>