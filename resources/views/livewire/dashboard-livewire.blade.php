<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
    
    * { 
        font-family: 'Poppins', sans-serif !important; 
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    @keyframes aurora {
        0%, 100% { transform: translateX(-50%) translateY(0) scale(1); opacity: 0.8; }
        50% { transform: translateX(-50%) translateY(-30px) scale(1.1); opacity: 1; }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.3); }
        50% { box-shadow: 0 0 40px rgba(99, 102, 241, 0.6); }
    }
    
    @keyframes float-up {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes rotate-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    [data-bs-theme="dark"] body {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    }
    
    .dashboard-wrapper {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border-radius: 32px;
        padding: 2rem;
        margin: 1rem;
    }
    
    .hero-section {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(168, 85, 247, 0.9));
        border-radius: 28px;
        padding: 3rem 2rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        top: -250px;
        left: 50%;
        transform: translateX(-50%);
        animation: aurora 8s ease-in-out infinite;
    }
    
    .hero-section::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }
    
    .avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    .avatar-circle::after {
        content: '✓';
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        border: 3px solid white;
    }
    
    .stat-card-modern {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(30px);
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        animation: float-up 0.6s ease-out;
    }
    
    [data-bs-theme="dark"] .stat-card-modern {
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #667eea);
        background-size: 300% 300%;
        border-radius: 24px;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s;
        animation: shimmer 3s linear infinite;
    }
    
    .stat-card-modern:hover::before {
        opacity: 1;
    }
    
    .stat-card-modern:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
    }
    
    .icon-box {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .icon-box i {
        font-size: 2.5rem;
        color: white;
        position: relative;
        z-index: 2;
    }
    
    .icon-box::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: inherit;
        border-radius: inherit;
        filter: blur(20px);
        opacity: 0.6;
        z-index: 1;
    }
    
    .amount-display {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
        margin: 1rem 0;
        letter-spacing: -1px;
    }
    
    .trend-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .chart-container-modern {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(30px);
        border-radius: 28px;
        padding: 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.5);
        animation: float-up 0.8s ease-out;
    }
    
    [data-bs-theme="dark"] .chart-container-modern {
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .action-button {
        padding: 14px 32px;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.875rem;
    }
    
    .action-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .action-button:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .action-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }
    
    .quick-stats {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .quick-stat-item {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 12px 24px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .quick-stat-item i {
        font-size: 1.5rem;
        color: rgba(255, 255, 255, 0.9);
    }
    
    .period-selector {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 6px;
        display: inline-flex;
        gap: 6px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .period-selector button {
        padding: 10px 24px;
        border-radius: 16px;
        border: none;
        background: transparent;
        color: inherit;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .period-selector button.active {
        background: white;
        color: #667eea;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    [data-bs-theme="dark"] .period-selector button.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .transaction-row {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s;
    }
    
    [data-bs-theme="dark"] .transaction-row {
        background: rgba(51, 65, 85, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .transaction-row:hover {
        transform: translateX(8px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .floating-action {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
        cursor: pointer;
        transition: all 0.3s;
        z-index: 1000;
        animation: pulse-glow 2s infinite;
    }
    
    .floating-action:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 15px 50px rgba(102, 126, 234, 0.6);
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
    }
</style>

<div class="dashboard-wrapper">
    {{-- Hero Section --}}
    <div class="hero-section" style="animation: float-up 0.5s ease-out;">
        <div class="position-relative" style="z-index: 10;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-4 mb-3">
                        @php
                            $name = $auth->name ?? 'User';
                            $initials = collect(explode(' ', $name))->map(function($word) {
                                return strtoupper(substr($word, 0, 1));
                            })->take(2)->join('');
                            $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEEAD', '#D4A5A5', '#9B59B6', '#3498DB'];
                            $colorIndex = abs(crc32($name)) % count($colors);
                            $bgColor = $colors[$colorIndex];
                        @endphp
                        
                        <div class="avatar-circle" style="background: {{ $bgColor }};">
                            {{ $initials }}
                        </div>
                        
                        <div class="text-white">
                            <h1 class="display-5 fw-bold mb-2">Halo, {{ $auth->name ?? 'User' }}! </h1>
                            <p class="fs-5 mb-0 opacity-90">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="quick-stats mt-4">
                        <div class="quick-stat-item">
                            <i class="bi bi-receipt"></i>
                            <div class="text-white">
                                <small class="d-block opacity-75">Transaksi</small>
                                <strong class="fs-5">{{ number_format(array_sum($monthly['income'] ?? []), 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <i class="bi bi-folder"></i>
                            <div class="text-white">
                                <small class="d-block opacity-75">Kategori</small>
                                <strong class="fs-5">{{ count($distribution['labels'] ?? []) }}</strong>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <i class="bi bi-calendar-week"></i>
                            <div class="text-white">
                                <small class="d-block opacity-75">Bulan Ini</small>
                                <strong class="fs-5">{{ now()->format('M Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 text-end d-none d-md-block">
                    <a href="{{ route('app.transactions') }}" class="action-button" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                        <i class="bi bi-plus-circle me-2"></i>
                        Transaksi Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="row g-4 mb-4">
        {{-- Income Card --}}
        <div class="col-md-6 col-lg-3" style="animation-delay: 0.1s;">
            <div class="stat-card-modern">
                <div class="icon-box" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </div>
                <div>
                    <p class="text-muted text-uppercase small fw-semibold mb-2" style="letter-spacing: 1.5px;">Pemasukan</p>
                    <div class="amount-display text-success">
                       Rp {{ number_format($stats['income'], 0, ',', '.') }}
                    </div>
                    <span class="trend-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                        <i class="bi bi-graph-up-arrow"></i>
                        bulan ini
                    </span>
                </div>
            </div>
        </div>

        {{-- Expense Card --}}
        <div class="col-md-6 col-lg-3" style="animation-delay: 0.2s;">
            <div class="stat-card-modern">
                <div class="icon-box" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                </div>
                <div>
                    <p class="text-muted text-uppercase small fw-semibold mb-2" style="letter-spacing: 1.5px;">Pengeluaran</p>
                    <div class="amount-display text-danger">
                        Rp {{ number_format(floatval(str_replace('.', '', $stats['expense'])), 0, ',', '.') }}
                    </div>
                    <span class="trend-badge" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;">
                        <i class="bi bi-graph-down-arrow"></i>
                        bulan ini
                    </span>
                </div>
            </div>
        </div>

        {{-- Net Balance Card --}}
        <div class="col-md-6 col-lg-3" style="animation-delay: 0.3s;">
            <div class="stat-card-modern">
                <div class="icon-box" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <p class="text-muted text-uppercase small fw-semibold mb-2" style="letter-spacing: 1.5px;">Saldo Bersih</p>
                    <div class="amount-display text-primary">
                        Rp {{ number_format(floatval(str_replace('.', '', $stats['net'])), 0, ',', '.') }}
                    </div>
                    <span class="trend-badge" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                        <i class="bi bi-check-circle-fill"></i>
                        Periode ini
                    </span>
                </div>
            </div>
        </div>

        {{-- Total Balance Card --}}
        <div class="col-md-6 col-lg-3" style="animation-delay: 0.4s;">
            <div class="stat-card-modern">
                <div class="icon-box" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                    <i class="bi bi-piggy-bank-fill"></i>
                </div>
                <div>
                    <p class="text-muted text-uppercase small fw-semibold mb-2" style="letter-spacing: 1.5px;">Total Saldo</p>
                    <div class="amount-display" style="color: #8b5cf6;">
                        Rp {{ number_format(floatval(str_replace('.', '', $stats['total'])), 0, ',', '.') }}
                    </div>
                    <span class="trend-badge" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">
                        <i class="bi bi-infinity"></i>
                        Akumulasi
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="chart-container-modern mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">📊 Analisis Keuangan</h3>
                <p class="text-muted mb-0">Visualisasi tren pemasukan & pengeluaran</p>
            </div>
            
            <div class="period-selector">
                <button class="active" data-period="6">6 Bulan</button>
                <button data-period="12">1 Tahun</button>
                <button data-period="all">Semua</button>
            </div>
        </div>

        <div class="d-flex gap-4 mb-4 flex-wrap">
            <div class="d-flex align-items-center gap-2">
                <div style="width: 16px; height: 16px; border-radius: 4px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                <span class="fw-semibold">Pemasukan</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div style="width: 16px; height: 16px; border-radius: 4px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></div>
                <span class="fw-semibold">Pengeluaran</span>
            </div>
        </div>
        
        <div id="trend-chart" style="height: 400px;"></div>
    </div>

    {{-- Recent Transactions --}}
    <div class="chart-container-modern">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">🕐 Transaksi Terbaru</h3>
                <p class="text-muted mb-0">{{ count($transactions) }} transaksi terakhir</p>
            </div>
            <a href="{{ route('app.transactions') }}" class="action-button" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 24px; font-size: 0.875rem;">
                Lihat Semua <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="transactions-list">
            @forelse($transactions as $transaction)
                <div class="transaction-row">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-calendar3 text-muted"></i>
                                <span class="fw-semibold">{{ $transaction->transaction_date->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-0 fw-medium">{{ Str::limit(strip_tags($transaction->description), 50) }}</p>
                        </div>
                        <div class="col-md-2">
                            <span class="badge px-3 py-2 {{ $transaction->type === 'income' ? 'text-bg-success' : 'text-bg-danger' }}">
                                {{ $transaction->type === 'income' ? '💰 Pemasukan' : '💸 Pengeluaran' }}
                            </span>
                        </div>
                        <div class="col-md-3 text-end">
                            <span class="fs-5 fw-bold {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="col-md-1 text-end">
                            <a href="{{ route('app.transactions', ['action' => 'detail', 'id' => $transaction->id]) }}"
                               class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada transaksi</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Floating Action Button --}}
    <a href="{{ route('app.transactions') }}" class="floating-action">
        <i class="bi bi-plus"></i>
    </a>
</div>

{{-- Scripts --}}
<script>
    (function() {
        let trendChart = null;
        
        function waitForApexCharts(callback) {
            if (typeof ApexCharts !== 'undefined') {
                callback();
            } else {
                setTimeout(() => waitForApexCharts(callback), 100);
            }
        }
        
        function initCharts() {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            
            const trendOptions = {
                series: [{
                    name: 'Pemasukan',
                    data: {!! json_encode($monthly['income'] ?? [1000, 1200, 1500, 1300, 1800, 2000]) !!}
                }, {
                    name: 'Pengeluaran',
                    data: {!! json_encode($monthly['expense'] ?? [800, 900, 1000, 1100, 1200, 1300]) !!}
                }],
                chart: {
                    type: 'area',
                    height: 400,
                    toolbar: { show: false },
                    background: 'transparent',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                colors: ['#667eea', '#f5576c'],
                stroke: { 
                    curve: 'smooth', 
                    width: 4 
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                markers: { 
                    size: 6,
                    strokeWidth: 3,
                    strokeColors: '#fff',
                    hover: { size: 8 }
                },
                xaxis: {
                    categories: {!! json_encode($monthly['months'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                    labels: { 
                        style: { 
                            colors: isDark ? '#9ca3af' : '#6b7280',
                            fontSize: '12px',
                            fontWeight: 600
                        } 
                    }
                },
                yaxis: {
                    labels: {
                        style: { 
                            colors: isDark ? '#9ca3af' : '#6b7280',
                            fontSize: '12px',
                            fontWeight: 600
                        },
                        formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                },
                grid: {
                    borderColor: isDark ? '#374151' : '#e5e7eb',
                    strokeDashArray: 4,
                    padding: {
                        top: 0,
                        right: 10,
                        bottom: 0,
                        left: 10
                    }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: { 
                        formatter: val => 'Rp ' + val.toLocaleString('id-ID') 
                    },
                    style: {
                        fontSize: '14px'
                    }
                },
                legend: {
                    show: false
                }
            };

            const trendEl = document.getElementById('trend-chart');
            
            if (trendEl && !trendChart) {
                trendChart = new ApexCharts(trendEl, trendOptions);
                trendChart.render();
            }
        }

        // Initialize
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                waitForApexCharts(initCharts);
            });
        } else {
            waitForApexCharts(initCharts);
        }

        // Period buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.period-selector button')) {
                const btn = e.target.closest('.period-selector button');
                document.querySelectorAll('.period-selector button').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
        });
    })();
</script>