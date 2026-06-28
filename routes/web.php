<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExhibitionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/login-action', function (Request $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        return redirect()->route('items.index');
    }
    return back()->withErrors(['email' => '認証情報が正しくありません。']);
})->name('login.action');

Route::middleware('auth')->group(function () {
    
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('mypage.profile'); 
    })->middleware(['signed'])->name('verification.verify');

    Route::get('/mypage/profile', [ProfileController::class, 'index'])->name('mypage.profile');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('mypage.update');

    Route::get('/mypage/show_list', [ProfileController::class, 'showList'])->name('mypage.show_list');
    
    Route::post('/item/{item_id}/comment', [ItemController::class, 'comment'])->name('items.comment');
    Route::post('/item/{item_id}/like', [LikeController::class, 'toggle'])->name('items.like');
    
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');
    
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.editAddress');
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.updateAddress');
    
    Route::get('/sell', [ExhibitionController::class, 'show'])->name('items.sell');
    Route::post('/sell', [ExhibitionController::class, 'store'])->name('items.store');
});