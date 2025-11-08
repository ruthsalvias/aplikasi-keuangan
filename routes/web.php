<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
// --- Import Livewire Components yang Baru ---
use App\Livewire\TransactionLivewire;
use App\Livewire\DashboardLivewire;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Rute untuk Login, Register, dan Logout (Tidak berubah dari sebelumnya)
*/
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

/*
|--------------------------------------------------------------------------
| Application Routes (Requires Authentication)
|--------------------------------------------------------------------------
| Rute utama aplikasi Keuangan (membutuhkan middleware 'check.auth')
*/
Route::group(['prefix' => 'app', 'middleware' => 'check.auth'], function () {
    
    // 1. DASHBOARD: Halaman utama dengan ringkasan dan grafik
    // Mengganti /home lama. Return the page view that mounts dashboard Livewire.
    Route::get('/dashboard', function () {
        return view('pages.app.home');
    })->name('app.dashboard');
    
    // 2. TRANSAKSI: Halaman daftar, filter, dan CRUD transaksi
    // Mengganti /todos lama. Return a page that mounts the Livewire component.
    Route::get('/transactions', function () {
        return view('app.transactions');
    })->name('app.transactions'); 
    
    // Rute lama /todos/{todo_id} dihapus/dikesampingkan, karena detail dihandle via modal.
    // Route::get('/todos/{todo_id}', [HomeController::class, 'todoDetail'])->name('app.todos.detail'); 
    
    // Rute /home lama sekarang redirect ke Dashboard
    Route::get('/home', function () { 
        return redirect()->route('app.dashboard');
    })->name('app.home');

    // Debug route: quick check for current user's transactions (dev helper)
    Route::get('/debug/transactions', function () {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'not authenticated'], 401);
        }

        $count = DB::table('transactions')->where('user_id', $user->id)->count();
        $latest = DB::table('transactions')->where('user_id', $user->id)->orderByDesc('id')->first();

        return response()->json([
            'user_id' => $user->id,
            'transactions_count' => $count,
            'latest_transaction' => $latest,
        ]);
    })->name('app.debug.transactions');

});

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Mengarahkan langsung ke dashboard setelah instalasi.
    return redirect()->route('app.dashboard');
});
