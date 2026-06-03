<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class)->except(['show']);
    Route::resource('/tasks', TaskController::class)->except(['show']);
    Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
    Route::post('/tasks/{task}/add-from-catalog', [TaskController::class, 'addFromCatalog'])->name('tasks.addFromCatalog');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Management Routes
    Route::post('/user', [ProfileController::class, 'storeUser'])->name('user.store');
    Route::put('/user/{user}', [ProfileController::class, 'updateUser'])->name('user.update');
    Route::delete('/user/{user}', [ProfileController::class, 'destroyUser'])->name('user.destroy');
    
    // Customer Management Routes (Admin)
    Route::post('/customer', [ProfileController::class, 'storeCustomer'])->name('customer.store');
    Route::put('/customer/{customer}', [ProfileController::class, 'updateCustomer'])->name('customer.update');
    Route::delete('/customer/{customer}', [ProfileController::class, 'destroyCustomer'])->name('customer.destroy');
    
    // Apply for Admin Route
    Route::post('/admin/apply', [ProfileController::class, 'applyForAdmin'])->name('admin.apply');
    
    // Admin routes (accessible to admin users only)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
        
        // Product management
        Route::get('/products', [\App\Http\Controllers\AdminController::class, 'listProducts'])->name('products.index');
        Route::get('/products/create', [\App\Http\Controllers\AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [\App\Http\Controllers\AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{product}/edit', [\App\Http\Controllers\AdminController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{product}', [\App\Http\Controllers\AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{product}', [\App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('products.delete');
        
        // User management
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'listUsers'])->name('users.index');
    });
});
