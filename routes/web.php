<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AgencyInquiryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\McmcInquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicInquiryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-link-sent', [AuthController::class, 'showResetLinkSent'])->name('password.link.sent');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/password/change', [AuthController::class, 'showPasswordChangeForm'])->name('password.change');
    Route::post('/password/change', [AuthController::class, 'changePassword']);
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'showChangePassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.update');
});

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'publicDashboard'])->name('dashboard');
    
    Route::prefix('inquiries')->group(function () {
        Route::get('/create', [PublicInquiryController::class, 'create'])->name('inquiries.create');
        Route::post('/', [PublicInquiryController::class, 'store'])->name('inquiries.store');
        Route::get('/my', [PublicInquiryController::class, 'myInquiries'])->name('inquiries.my');
        Route::get('/{inquiry}', [PublicInquiryController::class, 'show'])->name('inquiries.show');
    });
});

Route::prefix('mcmc')->name('mcmc.')->middleware(['auth', 'mcmc'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'mcmcDashboard'])->name('dashboard');
    
    Route::prefix('inquiries')->group(function () {
        Route::get('/', [McmcInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/statistics', [McmcInquiryController::class, 'statistics'])->name('inquiries.statistics');
        Route::get('/{inquiry}', [McmcInquiryController::class, 'show'])->name('inquiries.show');
        Route::patch('/{inquiry}/status', [McmcInquiryController::class, 'updateStatus'])->name('inquiries.update-status');
        Route::post('/{inquiry}/assign', [McmcInquiryController::class, 'assign'])->name('inquiries.assign');
        Route::post('/{inquiry}/reassign', [McmcInquiryController::class, 'reassign'])->name('inquiries.reassign');
    });
    
    Route::resource('/users', UserController::class);
    Route::resource('/agencies', AgencyController::class);

    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/users-statistics', [UserController::class, 'statistics'])->name('users.statistics');
    Route::get('/users-report', [UserController::class, 'report'])->name('users.report');
});

Route::prefix('agency')->middleware(['auth', 'agency'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'agencyDashboard'])->name('agency.dashboard');
    
    Route::prefix('inquiries')->group(function () {
        Route::get('/', [AgencyInquiryController::class, 'index'])->name('agency.inquiries.index');
        Route::get('/{inquiry}', [AgencyInquiryController::class, 'show'])->name('agency.inquiries.show');
        Route::post('/{inquiry}/accept', [AgencyInquiryController::class, 'accept'])->name('agency.inquiries.accept');
        Route::post('/{inquiry}/reject', [AgencyInquiryController::class, 'reject'])->name('agency.inquiries.reject');
        Route::patch('/{inquiry}/progress', [AgencyInquiryController::class, 'updateProgress'])->name('agency.inquiries.update-progress');
    });
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('agency.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('agency.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('agency.profile.update');
});
