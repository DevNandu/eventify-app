<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('events', EventController::class)->middleware('auth');
Route::post('/events/{event}/invite', [EventController::class, 'invite'])->name('events.invite');
Route::get('/events', [EventController::class, 'publicIndex'])->name('events.publicIndex');
Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics');
Route::get('/my-events', [EventController::class, 'myEvents'])->name('myEvents');
Route::delete('/events/{event}/invite/{invitation}', [EventController::class, 'removeInvite'])->name('events.removeInvite');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
