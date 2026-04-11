<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');

    Route::get('/product/create', [ProductController::class, 'create'])
        ->name('product.create')
        ->middleware('can:manage-product');

    Route::post('/product', [ProductController::class, 'store'])
        ->name('product.store')
        ->middleware('can:manage-product');

    Route::get('/product/export', [ProductController::class, 'export'])
        ->name('product.export')
        ->middleware('can:manage-product');

    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])
        ->name('product.edit')
        ->middleware('can:manage-product');

    Route::put('/product/update/{id}', [ProductController::class, 'update'])
        ->name('product.update')
        ->middleware('can:manage-product');

    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])
        ->name('product.delete')
        ->middleware('can:manage-product');

    Route::get('/category', function() {
        return "Ini adalah halaman kategori khusus admin.";
    })->name('category.index')->middleware('can:manage-product');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';