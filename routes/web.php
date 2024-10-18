<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarsController;

// 홈 페이지 라우트
Route::get('/', function () {
    return inertia('Home');
})->name('home');

// 차량 관련 라우트
Route::resource('cars', CarController::class)->except(['edit', 'update', 'destroy']);

// 예약 관련 라우트
Route::resource('reservations', ReservationController::class);
Route::post('/reservations/check-availability', [ReservationController::class, 'checkAvailability']);
Route::post('/reservations/{car}', [ReservationController::class, 'reserve']);
Route::get('/reservations/status/{car}', [ReservationController::class, 'checkStatus']);
Route::delete('/reservations/{car}', [ReservationController::class, 'cancel']);
Route::post('/reservations/store/{car}', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('reservations/check/{car}', function ($car) {
    // $pageData 변수를 사용하지 않거나, 필요하다면 여기서 정의하세요
    // 예: $pageData = [...];
    
    // 나머지 코드...
    return response()->json([/* 필요한 데이터 */]);
});
Route::post('/reservations/cancel/{car}', [ReservationController::class, 'cancel'])->name('reservations.cancel');

// 인증 관련 라우트
Route::get('/login', function () {
    return inertia('Auth/Login');
})->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::get('/register', function () {
    return inertia('Auth/Register');
})->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 이메일 인증 관련 라우트
Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// 인증이 필요한 라우트들
Route::middleware(['auth'])->group(function () {
    // 차량 추가 관련 라우트
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');

    // 예약 관련 라우트
    Route::get('reservations/create/{car}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
});

Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
Route::post('/cars', [CarController::class, 'store'])->name('cars.store');

Route::get('/{any}', function () {
    return view('app', ['page' => $pageData]);
})->where('any', '.*');

// 모든 요청을 처리하는 fallback 라우트
Route::fallback(function () {
    return Inertia::render('NotFound');
});

// 차량 상세 페이지 라우트
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');

Route::get('/cars/{car}/reservation-status', [CarController::class, 'checkReservationStatus']);

Route::get('/api/cars/{car}', [CarController::class, 'show']);

Route::delete('/cars/{id}', [CarController::class, 'destroy'])->name('cars.destroy');
