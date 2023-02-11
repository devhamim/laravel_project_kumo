<?php

use App\Http\Controllers\bannerController;
use App\Http\Controllers\cartcontroller;
use App\Http\Controllers\catagorycontroller;
use App\Http\Controllers\checkoutcontroller;
use App\Http\Controllers\couponcontroller;
use App\Http\Controllers\customerLogincontroller;
use App\Http\Controllers\customerProfilecontroller;
use App\Http\Controllers\customerRegistercontroller;
use App\Http\Controllers\frontendcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ordercontroller;
use App\Http\Controllers\prodaCtcontroller;
use App\Http\Controllers\rolecontroller;
use App\Http\Controllers\searchController;
use App\Http\Controllers\shopcontroller;
use App\Http\Controllers\socialCountroller;
use App\Http\Controllers\subcatagorycontroller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\wishController;

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

// frontend
Route::get('/', [frontendcontroller::class, 'index'])->name('index');
Route::get('/product/details/{slug}', [frontendcontroller::class, 'details'])->name('details');
Route::post('/getsize', [frontendcontroller::class, 'getsize']);
Route::get('/customer/reglogin', [frontendcontroller::class, 'customer_reg_login'])->name('customer.reglogin');
Route::get('/cart', [frontendcontroller::class, 'cart'])->name('cart');
Route::get('/catagory/product/{catagory_id}', [frontendcontroller::class, 'catagory_product'])->name('catagory.product');

// review
Route::post('/review/store', [frontendcontroller::class, 'review_store'])->name('review.store');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// users
Route::get('/user', [HomeController::class, 'users'])->name('user');
Route::get('/user/delete/{user_id}', [HomeController::class, 'users_delete'])->name('user.delete');

// user logout
Route::get('/user/logout', [HomeController::class, 'user_logout'])->name('user.logout');

// profile
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [HomeController::class, 'profile_edit'])->name('profile.edit');
Route::post('/profile/update', [HomeController::class, 'profile_update'])->name('profile.update');
Route::post('/profile/password/update', [HomeController::class, 'profile_password_update'])->name('profile.password.update');
Route::post('photo/update', [HomeController::class, 'photo_update'])->name('photo.update');


// catagory
Route::get('/catagory',[catagorycontroller::class,'catagorys'])->name('catagory');
Route::post('/catagory/store',[catagorycontroller::class,'catagory_store'])->name('catagory.store');
Route::get('/catagory/delete/{catagoris_id}',[catagorycontroller::class,'catagory_delete'])->name('catagory.delete');
Route::get('/catagory/edit/{catagoris_id}',[catagorycontroller::class,'catagory_edit'])->name('catagory.edit');
Route::post('/catagory/update/',[catagorycontroller::class,'catagory_update'])->name('catagory.update');
Route::get('/catagory/trash', [catagorycontroller::class, 'catagory_trash'])->name('catagory.trash');
Route::get('/catagory/hard/delete/{catagoris_id}', [catagorycontroller::class, 'catagory_hard_delete'])->name('catagory.hard.delete');
Route::get('/catagory/restore/{catagoris_id}', [catagorycontroller::class, 'catagory_restore'])->name('catagory.restore');


//subcatagory
Route::get('/subcatagory', [subcatagorycontroller::class, 'subcatagory'])->name('subcatagory');
Route::post('/subcatagory/store', [subcatagorycontroller::class, 'subcatagory_store'])->name('subcatagory.store');
Route::get('/subcatagory/delete/{subcatagoris_id}', [subcatagorycontroller::class, 'subcatagory_delete'])->name('subcatagory.delete');
Route::get('subcatagory/edit/{subcatagoris_id}', [subcatagorycontroller::class, 'subcatagory_edit'])->name('subcatagory.edit');
Route::get('/subcatagory/trash', [subcatagorycontroller::class, 'subcatagory_trash'])->name('subcatagory.trash');
Route::get('/subcatagory/hard/delete/{subcatagoris_id}', [subcatagorycontroller::class, 'subcatagory_hard_delete'])->name('subcatagory.hard.delete');
Route::get('/subcatagory/restore/{subcatagoris_id}', [subcatagorycontroller::class, 'subcatagory_restore'])->name('subcatagory.restore');
Route::post('/subcatagory/update', [subcatagorycontroller::class, 'subcatagory_update'])->name('subcatagory.update');


//prodact
Route::get('/prodact', [prodaCtcontroller::class, 'prodact'])->name('prodact');
Route::post('/getsubcatagory', [prodaCtcontroller::class, 'getsubcatagory']);
Route::post('/prodact/store', [prodaCtcontroller::class, 'prodact_store'])->name('prodact.store');
Route::get('/prodact/list', [prodaCtcontroller::class, 'prodact_list'])->name('prodact.list');
Route::get('/prodact/delete/{prodact_id}', [prodaCtcontroller::class, 'prodact_delete'])->name('prodact.delete');
Route::get('/variation', [prodaCtcontroller::class, 'variation'])->name('variation');
Route::post('/variation/store', [prodaCtcontroller::class, 'variation_store'])->name('variation.store');
Route::get('/prodact/inventory/{prodact_id}', [prodaCtcontroller::class, 'prodact_inventory'])->name('prodact.inventory');
Route::post('/prodact/inventory/store', [prodaCtcontroller::class, 'inventory_store'])->name('inventory.store');

// coupon
Route::get('/coupon',[couponcontroller::class, 'coupon'])->name('coupon');
Route::post('/coupon/store',[couponcontroller::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupon/delete/{coupon_id}', [couponcontroller::class, 'coupon_delete'])->name('coupon.delete');

// order
Route::get('/order', [ordercontroller::class, 'order'])->name('order');
Route::post('/order/status', [ordercontroller::class, 'order_status'])->name('order.status');


//cart
Route::post('/add/cart', [cartcontroller::class, 'add_cart'])->name('add.cart');
Route::get('/cart/remove/{cart_id}', [cartcontroller::class, 'cart_remove'])->name('cart.remove');
Route::post('/cart.update', [cartcontroller::class, 'cart_update'])->name('cart.update');

// wishlist
Route::get('/wish', [wishController::class, 'wish'])->name('wish');
Route::post('/add/wish', [wishController::class, 'add_wish'])->name('add.wish');
Route::get('/wish/delete/{wish_id}', [wishController::class, 'wish_delete'])->name('wish.delete');

// customer register
Route::post('/customer/store', [customerRegistercontroller::class, 'customer_store'])->name('customer.store');
Route::post('/customer/login', [customerLogincontroller::class, 'customer_login'])->name('customer.login');
Route::get('/customer/logout', [customerLogincontroller::class, 'customer_logout'])->name('customer.logout');
// customer email verify
Route::get('/customer/email/verify{token}', [customerRegistercontroller::class, 'customer_email_verify'])->name('customer.email.verify');

// customer social login
Route::get('/github/redirect', [socialCountroller::class, 'github_redirect'])->name('github.redirect');
Route::get('/github/callback', [socialCountroller::class, 'github_callback'])->name('github.callback');

Route::get('/google/redirect', [socialCountroller::class, 'google_redirect'])->name('google.redirect');
Route::get('/google/callback', [socialCountroller::class, 'google_callback'])->name('google.callback');

// customer forget password reset
Route::get('/customer/pass/reset', [customerLogincontroller::class, 'customer_pass_reset'])->name('customer.pass.reset');
Route::post('/customer/pass/reset/send', [customerLogincontroller::class, 'customer_pass_reset_send'])->name('customer.pass.reset.send');
Route::get('/customer/pass/mail/reset/{token}', [customerLogincontroller::class, 'customer_pass_mail_reset'])->name('customer.pass.mail.reset');
Route::post('/customer/pass/reset/confirm', [customerLogincontroller::class, 'customer_pass_reset_confirm'])->name('customer.pass.reset.confirm');

// customer profile
Route::get('/customer/profile', [customerProfilecontroller::class, 'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/store', [customerProfilecontroller::class, 'customer_profile_store'])->name('customer.profile.store');
Route::get('/customer/order', [customerProfilecontroller::class, 'customer_order'])->name('customer.order');


//checkout
Route::get('/checkout', [checkoutcontroller::class, 'checkout'])->name('checkout');
Route::post('/getcity', [checkoutcontroller::class, 'getcity']);
Route::post('/order/store', [checkoutcontroller::class, 'order_store'])->name('order.store');
Route::get('/order/success', [checkoutcontroller::class, 'order_success'])->name('order.success');

// stripe peyment methord
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
// Route::get('stripe', [StripePaymentController::class, 'stripe']);
// Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

// invoice download
Route::get('/invoice/download/{order_id}', [customerProfilecontroller::class, 'invoice_download'])->name('invoice.download');

//role
Route::get('/role', [rolecontroller::class, 'role'])->name('role');
Route::post('/add/permission', [rolecontroller::class, 'add_permission'])->name('add.permission');
Route::post('/add/role', [rolecontroller::class, 'add_role'])->name('add.role');
Route::get('/user/role', [rolecontroller::class, 'user_role'])->name('user.role');
Route::post('/user/role/store', [rolecontroller::class, 'user_role_store'])->name('user.role.store');
Route::get('/remove/role/{user_id}', [rolecontroller::class, 'remove_role'])->name('remove.role');
Route::get('/permition/delete{role_id}', [rolecontroller::class, 'permition_delete'])->name('permition.delete');


//shop
Route::get('/shop', [shopcontroller::class, 'shop'])->name('shop');

// banner
Route::get('/add/banner', [bannerController::class, 'add_banner'])->name('add.banner');
Route::post('/banner/store', [bannerController::class, 'banner_store'])->name('banner.store');
Route::get('/banner/delete/{banner_id}', [bannerController::class, 'banner_delete'])->name('banner.delete');
// shop banner
Route::get('/shop/banner', [bannerController::class, 'shop_banner'])->name('shop.banner');
Route::post('/shop/banner/store', [bannerController::class, 'shop_banner_store'])->name('shop.banner.store');
Route::get('/shop/banner/delete/{shop_id}', [bannerController::class, 'shop_banner_delete'])->name('shop.banner.delete');

