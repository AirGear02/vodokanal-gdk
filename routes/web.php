<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ContragentInfoController;
use App\Http\Controllers\ContragentsController;
use App\Http\Controllers\GdkTestsController;
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

ray()->showQueries();
Route::get('/', function () {
    return to_route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('contragents', ContragentsController::class);
    Route::resource('contragents.gdk-tests', GdkTestsController::class);

    Route::apiResource('contragents.info', ContragentInfoController::class)->only('store', 'update');

    Route::group(['prefix' => 'calendar'], function () {
       Route::get('/', [CalendarController::class, 'index'])->name('calendar.index');
       Route::group(['prefix' => 'notes'], function () {
          Route::post('/', [CalendarController::class, 'storeNote'])->name('calendar.store-note');
          Route::get('/', [CalendarController::class, 'getNotes'])->name('calendar.get-notes');
       });
    });
});
