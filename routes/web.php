<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ActorController, DashboardController, CustomerController};

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

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/login', [DashboardController::class, 'login'])->name('login');

// ACTOR AJAX
Route::get('/actor',[ActorController::class, 'index'])->name('actor.list');
Route::get('/actor/get-actor-list', [ActorController::class, 'getActorList'])->name('get.actor.list');
Route::get('/actor/get-actor-details', [ActorController::class, 'getActorDetails'])->name('get.actor.details');
Route::post('/actor/update-actor-details', [ActorController::class, 'updateActorDetails'])->name('update.actor.details');
Route::post('/actor/add-actor', [ActorController::class, 'addActor'])->name('add.actor');
Route::post('/actor/delete-actor', [ActorController::class, 'deleteActor'])->name('delete-actor');

Route::resource('customer', CustomerController::class);
