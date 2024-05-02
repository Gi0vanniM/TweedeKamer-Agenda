<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AgendaItemController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\ParliamentMemberController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
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
    return Inertia::render('welcome');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    // route to get the agenda
    Route::get('/agenda/{date?}', [AgendaController::class, 'index',]);

    Route::name('agendaitem.')->prefix('agendaitem')->group(function () {
        Route::get('/create', [AgendaItemController::class, 'create'])->name('create');
        Route::post('/store', [AgendaItemController::class, 'store'])->name('store');

        Route::get('/edit/{agendaItem}', [AgendaItemController::class, 'edit'])->name('edit');
        Route::put('/update/{agendaItem}', [AgendaItemController::class, 'update'])->name('update');

        Route::delete('/destroy/{agendaItem}', [AgendaItemController::class, 'destroy'])->name('destroy');
    });

    Route::name('admin.')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('user.index');

        Route::name('user.')->prefix('user')->group(function () {
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::put('/update', [UserController::class, 'update'])->name('update');
            Route::delete('/destroy', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::name('parliamentmember.')->prefix('parliamentmember')->group(function () {
            Route::post('/store', [ParliamentMemberController::class, 'store'])->name('store');
            Route::put('/update', [ParliamentMemberController::class, 'update'])->name('update');
            Route::delete('/destroy', [ParliamentMemberController::class, 'destroy'])->name('destroy');
        });
    });

    // debug
    Route::get('/debug', [DebugController::class, 'debug']);
});
