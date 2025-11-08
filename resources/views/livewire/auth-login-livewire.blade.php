<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    
    <form wire:submit.prevent="login">
        <div class="card shadow-lg border-0 rounded-4" style="max-width: 380px;">
            <div class="card-body p-4 p-md-5">
                
                {{-- Header / Logo --}}
                <div class="text-center mb-4">
                    {{-- Ganti logo dengan ikon yang lebih stylish atau pastikan logo Anda beresolusi tinggi --}}
                    <i class="bi bi-currency-dollar text-primary display-4 mb-2"></i> 
                    <h2 class="fw-bold text-dark mb-1">Selamat Datang</h2>
                    <p class="text-muted">Masuk untuk mengakses Aplikasi Keuangan Anda.</p>
                </div>
                
                <hr class="mb-4">
                
                {{-- Alamat Email --}}
                <div class="form-floating mb-3">
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="emailInput" 
                        wire:model="email" 
                        placeholder="nama@contoh.com"
                        required>
                    <label for="emailInput"><i class="bi bi-envelope me-2"></i> Alamat Email</label>
                    @error('email')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Kata Sandi --}}
                <div class="form-floating mb-4">
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="passwordInput" 
                        wire:model="password" 
                        placeholder="Kata Sandi"
                        required>
                    <label for="passwordInput"><i class="bi bi-lock me-2"></i> Kata Sandi</label>
                    @error('password')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Kirim --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold" wire:loading.attr="disabled">
                        <span wire:loading.remove>Masuk Sekarang</span>
                        <span wire:loading><span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...</span>
                    </button>
                </div>

                <hr class="mt-4">
                
                {{-- Tautan Daftar --}}
                <p class="text-center mb-0">
                    Belum memiliki akun? 
                    <a href="{{ route('auth.register') }}" class="fw-bold text-primary text-decoration-none">Daftar Akun Baru</a>
                </p>
            </div>
        </div>
    </form>
</div>
