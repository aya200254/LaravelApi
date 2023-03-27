<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\userController;

// product routes

// Route::post('/products', [ProductController::class, 'add']);
// Route::put('/products', [ProductController::class, 'update']);
// Route::delete('/products', [ProductController::class, 'delete']);
// Route::get('/products', [ProductController::class, 'show']);
// user routes

Route::any('add', [ProductController::class, 'add']);
Route::any('update', [ProductController::class, 'update']);
Route::any('delete', [ProductController::class, 'delete']);
Route::any('show', [ProductController::class,'show']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
