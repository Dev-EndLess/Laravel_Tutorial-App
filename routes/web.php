<?php
/*
| 
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Models\Band;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  

// All Bands
Route::get('/', [BandController::class, 'index']);

// Show Create Form 
Route::get('/bands/create', [BandController::class, 'create'])->middleware('auth');

// Show Edit Form
Route::get('/bands/{band}/edit', [BandController::class, 'edit'])->middleware('auth');

// Show Updated Form
Route::put('/bands/{band}', [BandController::class, 'update'])->middleware('auth');

// Delete Bandg
Route::delete('/bands/{band}', [BandController::class, 'destroy'])->middleware('auth');

// Manage Bands
Route::get('/bands/manage', [BandController::class, 'manage'])->middleware('auth');

// Store Band data
Route::post('/bands', [BandController::class, 'store'])->middleware('auth');

// Single Band
Route::get('/bands/{band}', [BandController::class, 'show']);

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create new Users
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


































// ** My Example/Test ** //

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/hello', function () {
//     return response('Hello!', 200)
//     ->header('content-type','application/json');

// });

// Route::get('/hell', function () {
//     return response([
//         'message' => 'Welcome in Hell',
//         'status' => 200
//         ])
//     ->header('content-type','application/json')
//     ->header('secret', 666);
// });


// Route::get('/users/{id}', function ($id) {
//     // dd($id);
//     return response('Post: ' . $id, 200);
// })->where('id', '[0-9]+');

// Route::get('/search', function (Request $request) {
//     //  dd($request);
//     return $request->name . ' ' . $request->city;
// });