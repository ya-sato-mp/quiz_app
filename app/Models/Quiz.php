<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quiz extends Model
{
    // フォームから一括保存を許可するカラムを指定
    protected $fillable = [
        'user_id',
        'question',
        'correct_answer',
        'choice_2',
        'choice_3',
        'choice_4',
        'image_path',
    ];

    // カテゴリとの多対多のリレーションを定義
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
