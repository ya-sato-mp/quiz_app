<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // 誰が作ったか
    $table->text('question'); // 問題文
    $table->string('correct_answer'); // 正解
    $table->string('choice_2'); // 不正解1
    $table->string('choice_3'); // 不正解2
    $table->string('choice_4'); // 不正解3
    $table->string('image_path')->nullable(); // 画像（空でもOK）
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
