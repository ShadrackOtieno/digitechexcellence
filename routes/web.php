<?php

use App\Http\Controllers\Admin as A;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

/* ------------------------------ Public site ------------------------------ */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{project:slug}', [WorkController::class, 'show'])->name('work.show');
Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServicePageController::class, 'show'])->name('services.show');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/start-a-project', [InquiryController::class, 'create'])->name('start');
Route::post('/start-a-project', [InquiryController::class, 'store'])->middleware('throttle:5,1')->name('start.store');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/* ------------------------------ Back office ------------------------------ */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [A\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [A\AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [A\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [A\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('projects', A\ProjectController::class)->except('show');
        Route::resource('categories', A\CategoryController::class)->except('show');
        Route::resource('technologies', A\TechnologyController::class)->except('show');
        Route::resource('services', A\ServiceController::class)->except('show');
        Route::resource('team', A\TeamController::class)->except('show');
        Route::resource('testimonials', A\TestimonialController::class)->except('show');

        Route::get('inquiries', [A\InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [A\InquiryController::class, 'show'])->name('inquiries.show');
        Route::put('inquiries/{inquiry}', [A\InquiryController::class, 'update'])->name('inquiries.update');
        Route::delete('inquiries/{inquiry}', [A\InquiryController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('messages', [A\MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [A\MessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [A\MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('settings', [A\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [A\SettingController::class, 'update'])->name('settings.update');
        Route::get('account', [A\AccountController::class, 'edit'])->name('account.edit');
        Route::put('account', [A\AccountController::class, 'update'])->name('account.update');
    });
});
