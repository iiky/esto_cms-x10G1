<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

View::composer('layouts.backend.main', function ($view) {

    $menus = menu();

    $view->with('menus', $menus);
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/user/role/{user}', [App\Http\Controllers\UserController::class, 'role'])->name('user.role');
    Route::post('/user/roleaction/{user}', [App\Http\Controllers\UserController::class, 'roleaction']);
    Route::resource('/user', App\Http\Controllers\UserController::class);

    Route::post('/role/showaction/{role}', [App\Http\Controllers\RoleController::class, 'showaction']);
    Route::resource('/role', App\Http\Controllers\RoleController::class);

    Route::resource('/permissiongroup', App\Http\Controllers\PermissionGroupController::class)->except('show');

    Route::resource('/permission', App\Http\Controllers\PermissionController::class)->except('show');

    Route::resource('/menu', App\Http\Controllers\MenuController::class)->except('show');

    Route::resource('/article_categories', App\Http\Controllers\ArticleCategoryController::class, ['parameters' => [
        'article_categories' => 'articleCategory:slug'
    ]])->except('show');

    Route::resource('/article', App\Http\Controllers\ArticleController::class)->parameters([
        'article' => 'article:slug',
    ]);
});
