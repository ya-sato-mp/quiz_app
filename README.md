# 🧠 世界のクイズ ＆ オリジナルクイズ共有アプリ（quiz_app）

海外のリアルタイムクイズAPIから問題を取得しつつ、自分たちでも画像付きのオリジナルクイズを投稿して遊べるWebサービス。

---

## 🗺️ 全体のイメージ（役割分担）

作るアプリの構造はこんな感じ。
担当する部屋が完全に分かれているので、お互いのコードがコンフリクすることはない

* **メイン画面（API・分析）：** [yasato] が担当（裏で全部繋ぎ込みます）
* **クイズ投稿部屋（CRUD）：** [yasato] が担当（問題文や画像を保存）
* **カテゴリ管理部屋（CRUD）：** ⭐️

---

## 🚀 環境構築

まずはプロジェクトを自分のPCに持ってきて、動かせる状態に。
ターミナルで1行ずつ実行。

# 1. データを自分のPCにダウンロード
git clone [https://github.com/ya-sato-mp/quiz_app.git](https://github.com/ya-sato-mp/quiz_app.git)
cd quiz_app

# 2. 必要なパーツ（ライブラリ）をインストール
composer install
npm install

# 3. 設定ファイル（.env）の作成
cp .env.example .env
php artisan key:generate
※ .env ファイルを開き、自分のデータベース設定（DB_DATABASE=データベース名など）に書き換え。

Bash
# 4. データベースにテーブルを作る
php artisan migrate



① ブランチを作る
作業を始める前に、必ずこのコマンドを打って自分専用の部屋に切り替えます。

Bash
git checkout -b partner-category

② キリが良いところで保存＆プッシュ
Bash
git add .
git commit -m "カテゴリの一覧画面を作ったよ"
git push origin partner-category
③ プルリク（合体申請）を出す
GitHubのブラウザ画面を開くと「Compare & pull request」という緑のボタンが出るので、それを押して僕に合体申請（プルリク）を送れば完了です！

🛠️ ⭐️相方さんの担当：『カテゴリの文字CRUD』
クイズのジャンル（例：「アニメ」「歴史」「IT」など）を登録・管理する機能を作ってもらいます。
画像や難しい設定は一切不要！授業でやった「Todoアプリの文字（タスク内容）」を「カテゴリ名」に変えるだけでOK。

📌 作る画面と処理は3つだけ！
一覧 ＆ 登録画面（GET: /categories）

今あるカテゴリが縦に並んでいて、新しく追加できる入力欄がある画面。

保存ボタンの裏側の処理（POST: /categories/create）

入力された文字をデータベースに保存する処理。

削除ボタンの裏側の処理（DELETE: /categories/{id}）

一覧の横にある「削除」ボタンを押したらデータを消す処理。

📁 触るファイル（ここ以外は触らなくてOK！）

ルート（道路）： routes/web.php

コントローラ（頭脳）： app/Http/Controllers/CategoryController.php

モデル（データ）： app/Models/Category.php

ビュー（見た目）： resources/views/categories/index.blade.php


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
