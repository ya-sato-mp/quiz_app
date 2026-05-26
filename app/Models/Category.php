<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // データの登録・更新を許可する項目を指定します
    protected $fillable = [
        'name',
    ];
}
