<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('sections', SectionController::class);
    Route::resource('branches', \App\Http\Controllers\BranchController::class);
    Route::resource('themes', \App\Http\Controllers\ThemeController::class);
    Route::resource('messages', \App\Http\Controllers\MessageController::class);

    Route::get('/sections/{section}/branches', [SectionController::class, 'sectionBranches'])->name('sections.branches');
    Route::get('/sections/{section}/branches_except/{branch}', [SectionController::class, 'sectionBranchesExcept'])->name('sections.branches.except');

    Route::get('/branches/{branch}/themes/create', [\App\Http\Controllers\BranchController::class, 'themeCreate'])->name('branches.themes.create');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
