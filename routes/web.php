<?php

use App\Models\Affiliation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AffiliationController::class, 'showForm']);

// 動的な選択肢を取得するためのルート
Route::get('/department', [AffiliationController::class, 'getDepartments']);
Route::get('/major', [AffiliationController::class, 'getMajors']);
