<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cr\CrController;
use App\Http\Controllers\Admin\AdminEventController;

Route::get('/', function () {
    return view('welcome');
});

// Normal Student Dashboard
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

      Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

//Cr
Route::middleware(['auth', 'verified', 'role:cr'])->group(function () {
    Route::get('/cr/dashboard', [CrController::class, 'index'])->name('cr.dashboard');
    Route::post('/cr/routine/store', [CrController::class, 'storeRoutine'])->name('cr.routine.store');
    Route::put('/cr/routine/{id}/update', [CrController::class, 'updateRoutine'])->name('cr.routine.update');
    Route::delete('/cr/routine/{id}/delete', [CrController::class, 'deleteRoutine'])->name('cr.routine.delete');
    Route::post('/cr/routine/{id}/cancel-date', [CrController::class, 'toggleCancelDate'])->name('cr.routine.cancel.date');
    Route::post('/cr/user/store', [CrController::class, 'storeUser'])->name('cr.user.store');
});

//admin 
Route::middleware(['auth', 'verified', 'role:super_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/user/store', [AdminController::class, 'storeUser'])->name('admin.user.store'); // <-- Add this line
    Route::post('/admin/user/{id}/make-cr', [AdminController::class, 'makeCr'])->name('admin.make.cr');
    Route::post('/admin/user/{id}/remove-cr', [AdminController::class, 'removeCr'])->name('admin.remove.cr');
    Route::get('/admin/events', [AdminEventController::class, 'index'])->name('admin.events');
    Route::post('/admin/event-category/store', [AdminEventController::class, 'storeCategory'])->name('admin.category.store');
    Route::post('/admin/event/store', [AdminEventController::class, 'storeEvent'])->name('admin.event.store');
    Route::get('/admin/event/{id}/registrations', [AdminEventController::class, 'viewRegistrations'])->name('admin.event.registrations');

});

require __DIR__.'/auth.php';
