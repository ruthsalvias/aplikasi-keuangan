{{-- Enhanced Sidebar Navigation Component --}}
<div class="sidebar-container">
    {{-- Logo & Brand --}}
    <div class="sidebar-logo">
        <a href="{{ route('app.dashboard') }}">
            <i class="bi bi-wallet2 fs-4"></i>
            <span class="ms-3">Keuangan.app</span>
        </a>
    </div>

    {{-- User Profile Quick Access --}}
    <div class="p-3">
        <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(var(--bs-primary-rgb), 0.1);">
            <div class="flex-shrink-0">
                <div class="rounded-circle bg-white p-2 shadow-sm">
                    <i class="bi bi-person-circle text-primary fs-4"></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 fw-semibold">{{ Auth::user()->name }}</h6>
                <p class="mb-0 small text-muted">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    <ul class="sidebar-navigation">
        <li class="header">MENU UTAMA</li>
        
        {{-- Dashboard --}}
        <li>
            <a href="{{ route('app.dashboard') }}" class="{{ request()->routeIs('app.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Transactions --}}
        <li>
            <a href="{{ route('app.transactions') }}" class="{{ request()->routeIs('app.transactions') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i>
                <span>Transaksi</span>
                @php
                    $transactionCount = \App\Models\Transaction::count();
                @endphp
                @if($transactionCount > 0)
                    <span class="badge bg-primary rounded-pill ms-auto">{{ $transactionCount }}</span>
                @endif
            </a>
        </li>

        {{-- Logout --}}
        <li>
            <a href="{{ route('auth.logout') }}" class="text-danger">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </a>
        </li>
    </ul>

    {{-- Sidebar Footer with Theme Toggle --}}
    <div class="sidebar-footer">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Mode Tampilan:</span>
            <button class="btn btn-link text-decoration-none p-0" id="theme-toggle">
                <i class="bi bi-sun-fill fs-5 text-warning" data-theme-icon="sun"></i>
                <i class="bi bi-moon-fill fs-5 text-primary d-none" data-theme-icon="moon"></i>
            </button>
        </div>
    </div>
</div>

{{-- Mobile Header --}}
<div class="mobile-header d-lg-none">
    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobile-sidebar" aria-controls="mobile-sidebar">
        <i class="bi bi-list"></i>
    </button>
    <div class="mobile-logo">Keuangan.app</div>
</div>