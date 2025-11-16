<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Routes protégées (nécessitent une authentification)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Tutoriels - Consultation (tous les utilisateurs)
    Route::get('/tutorials', [App\Http\Controllers\TutorialController::class, 'index'])->name('tutorials.index');
    Route::get('/tutorials/{tutorial}', [App\Http\Controllers\TutorialController::class, 'show'])->name('tutorials.show');

    // Mes tutoriels - Gestion (utilisateurs avec branche)
    Route::middleware('can:create,App\Models\Tutorial')->group(function () {
        Route::resource('my-tutorials', App\Http\Controllers\MyTutorialController::class)->except(['show']);
    });

    // Administration (admin uniquement)
    Route::middleware('can:viewAny,App\Models\User')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('branches', App\Http\Controllers\Admin\BranchController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });

    // Notifications
// Notifications
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    })->name('notifications.mark-all-read');
});
