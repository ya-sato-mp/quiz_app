<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    /**
     * クイズ作成画面を表示する
     */
    public function create()
    {
        // 相方が作ったカテゴリをチェックボックスで選べるように、全件取得する
        $categories = Category::all();

        return view('quizzes.create', compact('categories'));
    }

    /**
     * クイズをデータベースに保存する（画像アップロード ＆ 多対多の紐付け）
     */
    public function store(Request $request)
    {
        // 1. バリデーション（入力チェック）
        $request->validate([
            'question' => 'required|string',
            'correct_answer' => 'required|string',
            'choice_2' => 'required|string',
            'choice_3' => 'required|string',
            'choice_4' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MBまでの画像
        ]);

        // 2. 画像アップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            // storage/app/public/quizzes フォルダにランダム名で保存
            $imagePath = $request->file('image')->store('quizzes', 'public');
        }

        // 3. クイズデータの保存
        $quiz = Quiz::create([
            'user_id' => auth()->id(), // 現在ログインしているユーザーのID
            'question' => $request->question,
            'correct_answer' => $request->correct_answer,
            'choice_2' => $request->choice_2,
            'choice_3' => $request->choice_3,
            'choice_4' => $request->choice_4,
            'image_path' => $imagePath,
        ]);

        // 4. 多対多の中間テーブルへの紐付け（Laravelが自動で中間テーブルに保存してくれます）
        if ($request->has('categories')) {
            $quiz->categories()->sync($request->categories);
        }

        // ダッシュボード（メイン画面）に戻る
        return redirect()->route('dashboard')->with('success', 'クイズを投稿しました！');
    }
    /**
     * オリジナルクイズの出題画面
     */
    public function showPlay()
    {
        // データベースからランダムに1問だけ取得
        $quiz = Quiz::inRandomOrder()->first();

        // 4つの選択肢（正解 + ダミー3つ）を配列にまとめてシャッフル
        $choices = [];
        if ($quiz) {
            $choices = [$quiz->correct_answer, $quiz->choice_2, $quiz->choice_3, $quiz->choice_4];
            shuffle($choices);
        }

        return view('quizzes.play', compact('quiz', 'choices'));
    }

    /**
     * オリジナルクイズの採点処理
     */
    public function checkAnswer(Request $request, Quiz $quiz)
    {
        $userAnswer = $request->input('answer');
        // 選んだボタンの文字と、正解の文字が一致しているか判定
        $isCorrect = trim($userAnswer) === trim($quiz->correct_answer);

        return view('quizzes.result', compact('quiz', 'userAnswer', 'isCorrect'));
    }
}
