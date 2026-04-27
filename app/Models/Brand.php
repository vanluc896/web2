<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    //- Bảng brands số nhiều nên không cần khai báo $table
    //- Khóa chính là id nên không cần khai báo $primaryKey
        protected $fillable=[
        'brandname',
        'slug',
        'description',
        'thumbnail', // thêm ảnh
        'status'     // trạng thái hiển thị
    ];
}
