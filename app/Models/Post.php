<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'userid',
        'image',
        'content',
        'status'
    ];

    // Quan hệ với User (người đăng bài)
    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
}