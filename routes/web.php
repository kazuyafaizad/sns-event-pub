<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeControler;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', HomeControler::class)->name('home');
    Route::resource('event', EventController::class);
    Route::resource('ticket', TicketController::class);
    Route::resource('users', UserController::class);
    Route::get('/profile', function () {
        return Inertia::render('Profile/Index');
    })->name('profile.index');

    // Route::group(function () {
    // Route::get('event', [EventController::class, 'index'])->name('index');
    // Route::get('event/new', [EventController::class, 'create'])->name('create');
    // Route::post('store', [EventController::class, 'store'])
    //     ->name('save');
    // Route::post('event/edit/{e}', [EventController::class, 'store'])
    //     ->name('edit');
    // Route::post('storeComment/{event}', [EventController::class, 'storeComment'])
    // ->name('comment');
    // Route::post('storeLike/{event}', [EventController::class, 'storeLike'])
    // ->name('like');
    // Route::post('visibility/{event}/{visibility}', [EventController::class, 'updateVisibility'])
    // ->name('visibility');
    // Route::post('showNotifications/{user}', [EventController::class, 'showNotifications'])
    // ->name('notification');
    // });
});

//Public
Route::name('public.')->group(function () {
    Route::get('event/{event}', [EventController::class, 'show'])->name('event.show');
    // Route::get('resume/{user}', [Public\ResumeController::class, 'show'])
    //     ->name('resume.show');
});
