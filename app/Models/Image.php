<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // 指定表名（可选，如果你的表名不符合 Laravel 的命名约定）
    protected $table = 'image';

    // 可填充的属性
    protected $fillable = ['image', 'post_id'];

    // 定义与 Post 模型的关系
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
