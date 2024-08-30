<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Livewire\Org\Omparator\OmparatorForm;
use App\Livewire\Org\Profile\ProfileEdit;
use App\Livewire\Org\Profile\ProfileForm;
use App\Livewire\Org\Role\RoleCreate;
use App\Livewire\Org\Role\RoleEdit;
use App\Livewire\Org\Role\RoleList;
use App\Livewire\Org\User;
use App\Livewire\Org\User\UserCreate;
use App\Livewire\Org\User\UserEdit;
use App\Livewire\User\Org\UserForm;
use App\Livewire\Org\User\UserList;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('dashboard/o/')
    ->name('org.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [DashboardController::class, "index"])->name('dashboard');

        Route::prefix('omparator')
            ->name('omparator.')
            ->group(function () {
                Route::get('/', OmparatorForm::class)->middleware(['permission:role:index'])->name('index');
            });

        Route::prefix('profile')
            ->name('profile.')
            ->group(function () {
             
                Route::post('edit', ProfileForm::class)->middleware(['permission:role:edit'])->name('edit');
            });
        Route::prefix('role')
            ->name('role.')
            ->group(function () {
                Route::get('/', RoleList::class)->middleware(['permission:role:index'])->name('index');
                Route::get('{role:id}/edit', RoleEdit::class)->middleware(['permission:role:edit'])->name('edit');
            });

        Route::prefix('user')
            ->name('user.')
            ->group(function () {
                Route::get('/', UserList::class)->middleware(['permission:role:index'])->name('index');
                Route::get('/create', UserCreate::class)->middleware(['permission:role:create'])->name('create');
                Route::get('/{user:id}/edit', UserEdit::class)->middleware(['permission:role:edit'])->name('edit');
            });
    });



// Route::get('/user/edit', [UserForm::class, 'edit'])->name('/user/edit');
// Route::get('/', [DashboardController::class, "index"])->name('dashboard');
