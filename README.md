# 🧠 世界のクイズ ＆ オリジナルクイズ共有アプリ（quiz_app）

海外のリアルタイムクイズAPIから問題を取得しつつ、自分たちでも画像付きのオリジナルクイズを投稿して遊べるWebサービス。

ファイル一覧にgeminiの引き継ぎ用のやつを作ってるから、コピペして投げたらいい感じに合流できると思う

---

## 🗺️ 全体のイメージ（役割分担）

アプリの構造はこんな感じです。担当するエリアを完全に分けているので、お互いのコードが衝突（コンフリクト）する心配はありません！

* **メイン画面（API連携・分析）：** [yasato] が担当（裏の繋ぎ込みは全部やります）
* **クイズ投稿機能（CRUD）：** [yasato] が担当（問題文やヒント画像の保存など）
* **カテゴリ管理機能（CRUD）：** ⭐️**[iizukaさん]** が担当（文字を保存するだけでOK！）

---

## 🚀 環境構築の手順

まずはプロジェクトを自分のPCに持ってきて、動かせる状態にします。ターミナルで1行ずつ実行してください。

### 1. データのダウンロードと移動
```bash
git clone [https://github.com/ya-sato-mp/quiz_app.git](https://github.com/ya-sato-mp/quiz_app.git)
cd quiz_app

```

### 2. ライブラリのインストール

```bash
composer install
npm install

```

### 3. 設定ファイル（.env）の準備

```bash
cp .env.example .env
php artisan key:generate

```

※ `.env` ファイルを開き、自分のデータベース設定（`DB_DATABASE=データベース名` など）に合わせて書き換えてください。

### 4. マイグレーション（テーブル作成）

```bash
php artisan migrate

```

---

## 🌿 Gitの作業ルール

**※重要：`main` ブランチで直接コードを書くのはNGでお願いします！**

### ① 自分の作業ブランチを作る（最初の一回だけ）

作業を始める前に、必ずこのコマンドを打って自分専用の部屋に切り替えてください。

```bash
git checkout -b iizuka-dev

```

### ② キリが良いところで保存＆プッシュ

```bash
git add .
git commit -m "カテゴリの一覧画面を作ったよ"
git push -u origin iizuka-dev

```

### ③ プルリク（合体申請）を出す

GitHubのブラウザ画面を開くと「**Compare & pull request**」という緑色のボタンが出るので、それを押して僕にプルリクを送れば作業完了です！

---

## 🛠️ ⭐️iizukaさんの担当：『カテゴリ管理（CRUD）』

クイズのジャンル（例：「アニメ」「歴史」「IT」など）を登録・管理する機能です。
画像アップロードや難しい設定は一切いりません！授業でやった「Todoアプリの文字（タスク内容）」を「カテゴリ名」に変えるイメージで大丈夫です。

### 📌 実装する機能はこれだけ！

1. **一覧表示 ＆ 登録画面**（`GET: /categories`）
* 今あるカテゴリが縦に並んでいて、新しく追加できる入力欄がある画面。


2. **保存処理**（`POST: /categories/create`）
* ボタンが押されたら、入力された文字をデータベースに保存する処理。


3. **削除処理**（`DELETE: /categories/{id}`）
* 一覧の横にある「削除」ボタンを押したら、そのデータを消す処理。



### 📁 触るファイル（ここ以外は触らなくて大丈夫）

ルート（道路）はもう作っておいたので、以下のファイルだけを編集・作成してください。

* **コントローラ（頭脳）：** `app/Http/Controllers/CategoryController.php` （なければ作成）
* **モデル（データ）：** `app/Models/Category.php`
* **マイグレーション：** `categories` テーブルを作る設定ファイル（id、name、timestampsがあればOK）
* **ビュー（見た目）：** `resources/views/categories/index.blade.php`

---

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
