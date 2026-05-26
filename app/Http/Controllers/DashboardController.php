<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. 外部APIから四択クイズを1問取得
        $response = Http::get('https://opentdb.com/api.php?amount=1&type=multiple');

        $apiQuiz = null;
        if ($response->successful() && isset($response->json()['results'][0])) {
            $apiQuiz = $response->json()['results'][0];
        }

        // 2. 自分が作ったオリジナルクイズ一覧を取得
        if (Schema::hasTable('category_quiz')) {
            $myQuizzes = Quiz::with('categories')->latest()->get();
        } else {
            $myQuizzes = Quiz::latest()->get();
        }

        // 3. 【分析機能】
        $totalQuizzes = Quiz::count();
        $userQuizzes = Quiz::where('user_id', auth()->id())->count();

        if (class_exists('App\Models\Category')) {
            $totalCategories = \App\Models\Category::count();
        } else {
            $totalCategories = 0;
        }

        return view('dashboard', compact('apiQuiz', 'myQuizzes', 'totalQuizzes', 'totalCategories', 'userQuizzes'));
    }
}
