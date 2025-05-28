<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Admin\AdminPosController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminTableController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminCashoutController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminPrintSettingController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
// Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/register', [AuthController::class, 'register']);


Route::prefix('{slug}')->group(function () {
    Route::prefix('cashier')->group(function () {

        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login']);
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        Route::middleware(['auth_admin'])->group(function () {
            Route::get('/download', function () {
                // Redirect ke URL unduhan resmi aplikasi Evokasir
                return redirect('https://play.google.com/store/apps/details?id=id.my.evognito.evokasir');
            })->name('download');

            Route::get('/', [AdminHomeController::class, 'index'])->name('admin.index');
            Route::get('/menu', [AdminMenuController::class, 'index'])->name('admin.menu.index');
            Route::get('/menu/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
            Route::post('/menu/create', [AdminMenuController::class, 'store'])->name('admin.menu.store');
            Route::get('/menu/edit/{id}', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
            Route::put('/menu/update/{id}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
            Route::delete('/menu/destroy/{id}', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');

            Route::middleware('role:Owner')->group(function () {
                Route::get('/users', [AdminAuthController::class, 'index'])->name('admin.users.index');
                Route::get('/users/create', [AdminAuthController::class, 'create'])->name('admin.users.create');
                Route::post('/users/create', [AdminAuthController::class, 'store'])->name('admin.users.store');
                Route::get('/users/edit/{id}', [AdminAuthController::class, 'edit'])->name('admin.users.edit');
                Route::put('/users/update/{id}', [AdminAuthController::class, 'update'])->name('admin.users.update');
                Route::delete('/users/destroy/{id}', [AdminAuthController::class, 'destroy'])->name('admin.users.destroy');
            });

            Route::get('/orders', [AdminOrdersController::class, 'index'])->name('admin.orders.index');
            Route::get('/orders/details/{order_code}', [AdminOrdersController::class, 'details'])->name('admin.orders.detail');
            Route::delete('/orders/destroy/{id}', [AdminOrdersController::class, 'destroy'])->name('admin.orders.destroy');
            Route::get('/orders/print/{order_code}', [AdminOrdersController::class, 'print'])->name('admin.orders.print');
            Route::patch('/orders/{order_code}/status', [AdminOrdersController::class, 'updateStatus'])->name('admin.orders.updateStatus');

            Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.setting.index');
            Route::post('/settings', [AdminSettingsController::class, 'saveSettings'])->name('admin.setting.save');
            Route::get('/print/setting', [AdminPrintSettingController::class, 'printSettingForm'])->name('admin.print-setting');
            Route::post('/print/setting', [AdminPrintSettingController::class, 'savePrintSetting'])->name('admin.print-setting.save');

            Route::get('/pos', [AdminPosController::class, 'index'])->name('admin.pos.index');
            Route::post('/pos/order', [AdminPosController::class, 'storeOrder'])->name('admin.pos.order.store');
            Route::get('/pos/order/print', [AdminPosController::class, 'index'])->name('admin.pos.order.print');

            Route::middleware('role:Owner')->group(function () {
                Route::get('/coupon', [AdminCouponController::class, 'index'])->name('admin.coupon.index');
                Route::post('/coupon', [AdminCouponController::class, 'store'])->name('admin.coupon.store');
                // Route::post('/coupon/create', [AdminCouponController::class, 'create'])->name('admin.coupon.create');
                // Route::post('/coupon/edit/{id}', [AdminCouponController::class, 'edit'])->name('admin.coupon.edit');
                Route::put('/coupon/update/{id}', [AdminCouponController::class, 'update'])->name('admin.coupon.update');
                Route::delete('/coupon/destroy/{id}', [AdminCouponController::class, 'destroy'])->name('admin.coupon.destroy');

                Route::get('/cashout', [AdminCashoutController::class, 'index'])->name('admin.cashout.index');
                Route::post('cashout', [AdminCashoutController::class, 'store'])->name('admin.cashout.store');
                Route::get('/cashout/form', [AdminCashoutController::class, 'create'])->name('admin.cashout.create');
            });
            Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.report.index');

            Route::get('/tables', [AdminTableController::class, 'index'])->name('admin.table.index');
            Route::get('/tables/create', [AdminTableController::class, 'create'])->name('admin.table.create');
            Route::post('/tables/store', [AdminTableController::class, 'store'])->name('admin.table.store');
            Route::get('/table/{id}/edit', [AdminTableController::class, 'edit'])->name('admin.table.edit');
            Route::get('/table/{id}/updatea', [AdminTableController::class, 'update'])->name('admin.table.update');
            Route::delete('/table/{id}/destroy', [AdminTableController::class, 'destroy'])->name('admin.table.destroy');


            Route::get('/check-new-orders', [AdminOrdersController::class, 'checkNewOrders'])
                ->name('admin.orders.checkNew');
            // ->middleware('auth');


        });
    });

    Route::get('/', [HomeController::class, 'index'])->name('user.index');

    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'userLogin'])->name('user.login');
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'userRegister'])->name('user.register');
    Route::middleware('role:User')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'userLogout'])->name('user.logout');
        // Route::get('/logout', [UserAuthController::class, 'userLogout'])->name('user.logout');
        Route::get('/profile', [UserAuthController::class, 'userProfile'])->name('user.profile');
        Route::get('/profile/edit', [UserAuthController::class, 'userProfile'])->name('user.edit.profile');
    });

    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/store', [CheckoutController::class, 'store'])->name('cart.store');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

    Route::get('/checkout/qris/{order_code}/{transaction_id}', [CheckoutController::class, 'showQris'])->name('checkout.qris');
    Route::get('/checkout/{order_code}/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/checkout/{order_code}/failed', [CheckoutController::class, 'checkoutFailed'])->name('checkout.failed');

    Route::post('/update-order-status', [CheckoutController::class, 'updateOrderStatus']);
});

Route::get('/time', function () {
    return view('time');
});
