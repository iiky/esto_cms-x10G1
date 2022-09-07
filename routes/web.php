<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;

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

function CreateMenuList($menu = NULL)
{
    $menu_array = array();
    if (is_null($menu)) {
        $menus = Menu::whereNull('menu_id')->orderBy('sort')->get();
    } else {
        $menus = Menu::where('menu_id', $menu->id)->get();
    }

    foreach ($menus as $menu) {
        $data = array();
        if (!is_null($menu->permission_group_id)) {
            $permissions = $menu->permissiongroup->permissions;
            $data_permission = array();
            foreach ($permissions as $permission) {
                $data_permission[] = $permission->name;
            }

            if (Auth::user()->canany($data_permission)) {
                $data['id'] = $menu->id;
                $data['menu_id'] = $menu->menu_id;
                $data['nama_menu'] = $menu->nama_menu;
                $data['icon'] = $menu->icon;
                $data['permission_group_id'] = $menu->permission_group_id;
                $data['href'] = $menu->href;
            }
        } else {
            $data_child = array();
            if (isset($menu->child)) {
                $data_array = CreateMenuList($menu);
                if (!is_null($data_array)) {
                    $data_child = CreateMenuList($menu);
                }
            }
            if (!empty($data_child)) {
                $data['id'] = $menu->id;
                $data['menu_id'] = $menu->menu_id;
                $data['nama_menu'] = $menu->nama_menu;
                $data['icon'] = $menu->icon;
                $data['permission_group_id'] = $menu->permission_group_id;
                $data['href'] = $menu->href;
                $data['child'] = $data_child;
            }
        }

        if (!empty($data)) {
            $menu_array[] = $data;
            $data = array();
        }
    }

    if (!empty($menu_array)) {
        return $menu_array;
    } else {
        return NULL;
    }
}

View::composer('layouts.backend.main', function ($view) {

    $menus = CreateMenuList();

    $view->with('menus', $menus);
});

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/user/role/{user}', [App\Http\Controllers\UserController::class, 'role'])->name('user.role');
    Route::post('/user/roleaction/{user}', [App\Http\Controllers\UserController::class, 'roleaction']);
    Route::resource('/user', App\Http\Controllers\UserController::class);

    Route::post('/role/showaction/{role}', [App\Http\Controllers\RoleController::class, 'showaction']);
    Route::resource('/role', App\Http\Controllers\RoleController::class);

    Route::resource('/permissiongroup', App\Http\Controllers\PermissionGroupController::class)->except('show');

    Route::resource('/permission', App\Http\Controllers\PermissionController::class)->except('show');

    Route::resource('/menu', App\Http\Controllers\MenuController::class, [
        'names' => [
            'index' => 'menu.index'
        ]
    ])->except('show');

    Route::resource('/article_categories', App\Http\Controllers\ArticleCategoryController::class, ['parameters' => [
        'article_categories' => 'articleCategory:slug'
    ]])->except('show');

    Route::resource('/article', App\Http\Controllers\ArticleController::class)->parameters([
        'article' => 'article:slug',
    ]);
});
