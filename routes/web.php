<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraduationController;
use App\Http\Controllers\AffiliationController;

// 学群・学類・専攻の選択フォームの表示php
Route::get('/', [AffiliationController::class, 'showForm']);

// 学群に対応する学類を取得
Route::get('/departments', [AffiliationController::class, 'getDepartments']);

// 学類に対応する専攻を取得
Route::get('/majors', [AffiliationController::class, 'getMajors']);

// 卒業判定処理
Route::post('/check', [GraduationController::class, 'checkRequirements']);
