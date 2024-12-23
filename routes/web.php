<?php

use App\Http\Controllers\MessageController;
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

    Route::get('/test', function (){
        event(new \App\Events\TestEvent());
    });

    Route::post('/messages/{message}/likes', [MessageController::class, 'toggleLike'])->name('messages.toggleLike');
    Route::post('/messages/{message}/compliant', [MessageController::class, 'compliantStore'])->name('messages.compliant.store');

    Route::get('/sections/{section}/branches', [SectionController::class, 'sectionBranches'])->name('sections.branches');
    Route::get('/sections/{section}/branches_except/{branch}', [SectionController::class, 'sectionBranchesExcept'])->name('sections.branches.except');

    Route::get('/branches/{branch}/themes/create', [\App\Http\Controllers\BranchController::class, 'themeCreate'])->name('branches.themes.create');

    Route::post('/images', [\App\Http\Controllers\ImageController::class, 'store'])->name('images.store');

    Route::get('/admin', [\App\Http\Controllers\Admin\MainController::class, 'index'])->name('admin.main.index');
    Route::get('/admin/complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('admin.complaints.index');
    Route::patch('/admin/complaints/{complaint}', [\App\Http\Controllers\Admin\ComplaintController::class, 'update'])->name('admin.complaints.update');

    Route::get('/admin/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/admin/roles/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/admin/roles', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/roles', [\App\Http\Controllers\Admin\UserController::class, 'toggleRoles'])->name('admin.users.toggleRoles');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
