<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
    {{-- Meta --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Icon --}}
    <link rel="icon" href="/logo.png" type="image/x-icon" />

    {{-- Judul --}}
    <title>{{ $title ?? 'Aplikasi Catatan Keuangan' }}</title>

    {{-- Styles --}}
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
    
    {{-- CUSTOM STYLE ANDA (TIDAK DIUBAH SAMA SEKALI) --}}
    <style>
        /* Gaya dasar untuk dark mode (otomatik) */
        :root, [data-bs-theme="light"] {
            --bs-body-bg: #f8f9fa; /* light background */
            --bs-body-bg-rgb: 248, 249, 250;
        }
        [data-bs-theme="dark"] {
            --bs-body-bg: #212529; /* dark background */
            --bs-body-bg-rgb: 33, 37, 41;
        }
        body {
            background-color: var(--bs-body-bg) !important;
        }
        /* Memperbaiki tampilan Trix Editor saat dark mode */
        [data-bs-theme="dark"] .trix-content {
            color: #d1d2d3; /* light text */
            background-color: #343a40; /* dark field background */
            border-color: #495057;
        }
        /* --- ENHANCED SIDEBAR STYLES (TIDAK DIUBAH) --- */
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #ffffff;
            --sidebar-link-color: #444444;
            --sidebar-link-hover-bg: #f8f9fa;
            --sidebar-link-active-color: #0d6efd;
            --sidebar-link-active-bg: #e7f1ff;
            --sidebar-header-color: #6c757d;
            --primary-blue: #0d6efd;
            --transition-speed: 0.3s;
        }
        [data-bs-theme="dark"] {
            --sidebar-bg: #1a1d20;
            --sidebar-link-color: #e9ecef;
            --sidebar-link-hover-bg: #2c3034;
            --sidebar-link-active-color: #3c91ff;
            --sidebar-link-active-bg: #2b3035;
            --sidebar-header-color: #adb5bd;
        }
        .page-wrapper { display: flex; min-height: 100vh; background-color: var(--bs-body-bg); }
        .sidebar-container { width: var(--sidebar-width); background-color: var(--sidebar-bg); box-shadow: 0 0 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: all var(--transition-speed) ease-in-out; position: fixed; height: 100vh; z-index: 1030; }
        .sidebar-logo { padding: 1.5rem; background: linear-gradient(135deg, var(--primary-blue) 0%, #0099ff 100%); margin-bottom: 0.5rem; }
        .sidebar-logo a { color: white; font-size: 1.5rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; text-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .sidebar-navigation { list-style: none; padding: 0.5rem; margin: 0; flex-grow: 1; overflow-y: auto; }
        .sidebar-navigation li a { display: flex; align-items: center; padding: 0.875rem 1.25rem; color: var(--sidebar-link-color); text-decoration: none; font-weight: 500; border-radius: 0.5rem; transition: all var(--transition-speed) ease; margin-bottom: 0.25rem; position: relative; }
        .sidebar-navigation li a:hover { background-color: var(--sidebar-link-hover-bg); color: var(--sidebar-link-active-color); transform: translateX(4px); }
        .sidebar-navigation li a.active { background-color: var(--sidebar-link-active-bg); color: var(--sidebar-link-active-color); font-weight: 600; box-shadow: 0 2px 6px rgba(13, 110, 253, 0.1); }
        .sidebar-navigation li a .bi { font-size: 1.25rem; margin-right: 1rem; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; }
        .sidebar-navigation .header { padding: 1.25rem 1rem 0.5rem; font-size: 0.75rem; font-weight: 600; color: var(--sidebar-header-color); text-transform: uppercase; letter-spacing: 0.5px; }
        .sidebar-footer { padding: 1rem; border-top: 1px solid var(--bs-border-color); background-color: var(--sidebar-bg); }
        .main-content { flex-grow: 1; padding: 2rem; margin-left: var(--sidebar-width); overflow-y: auto; min-height: 100vh; transition: margin-left var(--transition-speed) ease; }
        .mobile-header { display: none; position: sticky; top: 0; z-index: 1030; background: linear-gradient(135deg, var(--primary-blue) 0%, #0099ff 100%); padding: 1rem; align-items: center; color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .mobile-header .btn { color: white; padding: 0.5rem; border-radius: 0.5rem; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; }
        .mobile-header .btn:hover { background: rgba(255, 255, 255, 0.2); }
        .mobile-header .btn i { font-size: 1.5rem; }
        .mobile-logo { font-weight: 700; color: white; font-size: 1.3rem; margin: 0 auto; text-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        @media (max-width: 991.98px) {
            .sidebar-container { display: none; }
            .mobile-header { display: flex; }
            .main-content { margin-left: 0; padding: 0; }
            .main-content > :not(.mobile-header) { padding: 1rem; }
            .offcanvas { background-color: var(--sidebar-bg); }
            .offcanvas-start { width: var(--sidebar-width); border-right: none; }
            .offcanvas .sidebar-container { display: flex; width: 100%; border-right: 0; position: relative; height: 100%; box-shadow: none; }
            .sidebar-logo { padding: 1.25rem; }
            .sidebar-navigation li a { padding: 1rem 1.25rem; }
            .sidebar-navigation li a:active { transform: scale(0.98); }
        }
    </style>
</head>

<body>
    
    <div class="page-wrapper">
        {{-- Desktop Sidebar --}}
        <aside class="d-none d-lg-block">
            {{-- File sidebar.blade.php Anda harus ada di resources/views/layouts/ --}}
            @include('layouts.sidebar')
        </aside>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobile-sidebar" aria-labelledby="mobile-sidebar-label">
            <div class="offcanvas-body p-0">
                @include('layouts.sidebar')
            </div>
        </div>

        {{-- Main Content Area --}}
        <main class="main-content">
            {{-- File sidebar-mobile-header.blade.php Anda harus ada di resources/views/layouts/ --}}
            @include('layouts.sidebar-mobile-header')

            {{-- Support both section-based layouts and component-style slots.
                 If a child view uses @section('content') / @yield('content'),
                 prefer that. Otherwise fall back to a Blade component $slot. --}}
            @hasSection('content')
                @yield('content')
            @elseif (isset($slot))
                {{ $slot }}
            @endif
        </main>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

    @livewireScripts
    @include('layouts.modal-handlers')

    {{-- =================================================================== --}}
    {{-- ============ BLOK SCRIPT YANG DIPERBAIKI (INTI MASALAH) ============ --}}
    {{-- =================================================================== --}}
    <script>
        // Fungsi untuk mengelola tema (dark/light mode)
        // Logika ini sudah benar, tidak perlu diubah.
        function setupTheme() {
            const getStoredTheme = () => localStorage.getItem('theme');
            const setStoredTheme = theme => localStorage.setItem('theme', theme);
            
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme();
                if (storedTheme) { return storedTheme; }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const setTheme = theme => {
                document.documentElement.setAttribute('data-bs-theme', theme);
                // Cek jika tombol toggle ada sebelum mengubah iconnya
                const moonIcon = document.querySelector('[data-theme-icon="moon"]');
                const sunIcon = document.querySelector('[data-theme-icon="sun"]');
                if (moonIcon && sunIcon) {
                    moonIcon.classList.toggle('d-none', theme !== 'dark');
                    sunIcon.classList.toggle('d-none', theme === 'dark');
                }
            };

            // Set tema saat halaman dimuat
            window.addEventListener('DOMContentLoaded', () => {
                setTheme(getPreferredTheme());

                const themeToggle = document.getElementById('theme-toggle');
                if(themeToggle) {
                    themeToggle.addEventListener('click', () => {
                        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                        setStoredTheme(newTheme);
                        setTheme(newTheme);
                    });
                }
            });
        }

        // Jalankan fungsi setup tema
        setupTheme();

        // Menunggu Livewire selesai diinisialisasi sebelum memasang listener
        document.addEventListener("livewire:initialized", () => {

            // Listener untuk MENAMPILKAN modal
            // Menggunakan Livewire.on() untuk menangkap event dari server
            Livewire.on("showModal", (event) => {
                // event.id akan berisi nama ID modal, contoh: 'editTransactionModal'
                const modalEl = document.getElementById(event.id);
                if (modalEl) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            });

            // Listener untuk MENUTUP modal
            Livewire.on("closeModal", (event) => {
                const modalEl = document.getElementById(event.id);
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    }
                }
            });
            
            // Listener untuk MENAMPILKAN notifikasi (SweetAlert)
            Livewire.on('showAlert', (event) => {
                Swal.fire({
                    icon: event.icon || 'success',
                    title: event.message, // Menggunakan 'message' sebagai judul agar lebih simpel
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    position: 'top-end'
                });
            });

        });
    </script>
</body>
</html>```

