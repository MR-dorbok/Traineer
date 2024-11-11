<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraineeController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('trainees', TraineeController::class)->middleware('role:admin');
Route::get('/trainees/{id}/edit', [TraineeController::class, 'edit'])->name('trainees.edit');
Route::post('/trainees/perform-action', [TraineeController::class, 'performAction'])->name('trainees.performAction');

Route::middleware(['role:admin'])->get('/admin-dashboard', function () {
    return view('admin.dashboard');
});

require __DIR__.'/auth.php';
