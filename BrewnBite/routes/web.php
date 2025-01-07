<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\CheckUserRole;

Route::redirect('/', '/login');

// Route Auth
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::post('/login',[AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/menu', [UserController::class, 'menu'])->name('menu');
});

Route::prefix('menu')->group(function () {
    Route::post('/insert', [EmployeeController::class, 'menu']);
});

// Route Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
    Route::get('/ratings', [AdminController::class, 'ratings'])->name('ratings');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/bestsellers', [AdminController::class, 'bestsellers'])->name('bestsellers');
});

// Route Karyawan
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/history', [EmployeeController::class, 'history'])->name('history');
    Route::get('/inventory', [EmployeeController::class, 'inventory'])->name('inventory');
    Route::get('/listmenu', [EmployeeController::class, 'listmenu'])->name('listmenu');
    Route::get('/editmenu/{id}', [EmployeeController::class, 'toeditMenu'])->name('editmenu');
    Route::post('/menu/insert', [EmployeeController::class, 'addmenu']);
    Route::post('/menu/deletemenu', [EmployeeController::class, 'deletemenu']);
    Route::post('/menu/insertrecipe', [EmployeeController::class, 'addrecipe']);
    Route::post('/menu/editmenu', [EmployeeController::class, 'editmenu']);
    Route::post('/menu/editrecipe', [EmployeeController::class, 'editrecipe']);
    Route::post('/ingredient/insert', [EmployeeController::class, 'insertIngredient']);
    Route::post('/ingredient/update', [EmployeeController::class, 'updateIngredient']);
    Route::post('/ingredient/delete', [EmployeeController::class, 'deleteIngredient']);
});
Route::get('/get-category/{id}', [EmployeeController::class, 'getCategory']);
Route::get('/get-unit/{id}', [EmployeeController::class, 'getUnit']);

// Route Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
    Route::get('/ratings', [AdminController::class, 'ratings'])->name('ratings');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/bestsellers', [AdminController::class, 'bestsellers'])->name('bestsellers');
});