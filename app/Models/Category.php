<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
        use SoftDeletes;
    //chỉ định tên bảng trong DB
    //(có thể bỏ qua khai báo $table nếu đặt theo nguyên tắc số nhiều)
    protected $table='categories';
    //chỉ định khóa chính
    //có thể bỏ qua khai báo $primaryKey nếu primary key là id
    protected $primaryKey = 'cateid';
    //các cột cho phép thêm/sửa dl
    protected $fillable=[
        'catename',
        'slug',
        'description',
        //--
        'thumbnail',
        'status'
    ];
}
