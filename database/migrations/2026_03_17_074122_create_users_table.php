<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('fullname');
            $table->string('email')->unique();
            //role: 1-admin 0-user
            $table->tinyInteger('role')->default(0);
            //Tạo ra cột remember_token
            //để lưu trữ token khi người dùng chọn nhớ tài khoản
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
