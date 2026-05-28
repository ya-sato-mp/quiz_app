<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController; // 2日目のAPI・分析用
use Illuminate\Support\Facades\Route;

// 1. トップ画面（誰でも見れる）
Route::get('/', function () {
    return view('welcome');
});

// 2. ログイン必須のグループ
Route::middleware(['auth', 'verified'])->group(function () {

    // 【共通】メインダッシュボード（APIクイズ表示 ＆ 分析結果表示）
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // 🧠 オリジナルクイズ機能（CRUD）
    // ==========================================
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{id}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::post('/quizzes/{id}/update', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{id}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

    // ==========================================
    // 🛠️ 相方の担当：カテゴリ管理機能（CRUD）
    // ==========================================
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // ==========================================
    // Laravel Breeze 標準のプロフィール管理
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/quizzes/play', [QuizController::class, 'showPlay'])->name('quizzes.play');
    Route::post('/quizzes/{quiz}/check', [QuizController::class, 'checkAnswer'])->name('quizzes.check');
});

require __DIR__.'/auth.php';
