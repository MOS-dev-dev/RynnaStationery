<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
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
Route::get('/products', [HomeController::class, 'products'])->name('products.index');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.show');
Route::get('/flash-sale', [HomeController::class, 'flashSale'])->name('flash_sale');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/voucher/apply', [CartController::class, 'applyVoucher'])->name('cart.voucher.apply');
Route::post('/cart/voucher/remove', [CartController::class, 'removeVoucher'])->name('cart.voucher.remove');
Route::get('/api/chat/messages', [\App\Http\Controllers\ChatController::class, 'getMessages'])->name('api.chat.messages');
Route::post('/api/chat/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('api.chat.send');


Route::get('/dashboard', function () {
    if (auth()->user() && auth()->user()->role === 'admin') {
        return app(\App\Http\Controllers\Admin\DashboardController::class)->index();
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Checkout và Đơn hàng
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/payment', [OrderController::class, 'payment'])->name('orders.payment');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/export', [App\Http\Controllers\Admin\DashboardController::class, 'export'])->name('dashboard.export');
    Route::get('dashboard/export-revenue', [App\Http\Controllers\Admin\DashboardController::class, 'exportRevenue'])->name('dashboard.export_revenue');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
    Route::post('orders/{order}/timeline', [\App\Http\Controllers\Admin\OrderController::class, 'storeTimeline'])->name('orders.timeline.store');
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);
    
    // Flash Sale
    Route::get('flash-sale', [App\Http\Controllers\Admin\FlashSaleController::class, 'index'])->name('flash_sale.index');
    Route::get('flash-sale/active', [App\Http\Controllers\Admin\FlashSaleController::class, 'active'])->name('flash_sale.active');
    Route::post('flash-sale/batch-update', [App\Http\Controllers\Admin\FlashSaleController::class, 'batchUpdate'])->name('flash_sale.batch_update');
    Route::post('flash-sale/toggle/{id}', [App\Http\Controllers\Admin\FlashSaleController::class, 'toggle'])->name('flash_sale.toggle');
    Route::post('flash-sale/update/{id}', [App\Http\Controllers\Admin\FlashSaleController::class, 'update'])->name('flash_sale.update');

    Route::get('inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'store'])->name('inventory.store');

    // Chat Management
    Route::get('chat', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/{id}', [\App\Http\Controllers\Admin\ChatController::class, 'show'])->name('chat.show');
    Route::post('chat/{id}/send', [\App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('chat/{id}/toggle', [\App\Http\Controllers\Admin\ChatController::class, 'toggleMode'])->name('chat.toggle');
});


require __DIR__.'/auth.php';
