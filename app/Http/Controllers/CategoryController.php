<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. 一覧表示と登録フォームの画面
    public function index()
    {
        $categories = Category::latest()->get(); // 最新順に全件取得
        return view('categories.index', compact('categories'));
    }

    // 2. 新しいカテゴリを保存する処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', // 文字数制限などのルール
        ]);

        Category::create($validated); // データベースに保存

        return redirect()->route('categories.index')->with('message', 'カテゴリを登録しました！');
    }

    // 3. 編集画面を表示する（index画面を流用して編集モードにします）
    public function edit($id)
    {
        $category = Category::findOrFail($id); // 編集したいデータを1件取得
        $categories = Category::latest()->get(); // 一覧も同時に出すため取得

        return view('categories.index', compact('category', 'categories'));
    }

    // 4. 編集された内容を更新する処理
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated); // データを更新

        return redirect()->route('categories.index')->with('message', 'カテゴリを更新しました！');
    }

    // 5. カテゴリを削除する処理
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete(); // データを削除

        return redirect()->route('categories.index')->with('message', 'カテゴリを削除しました。');
    }
}
