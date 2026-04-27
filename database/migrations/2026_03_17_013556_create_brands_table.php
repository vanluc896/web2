<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('brandname')->unique();
            $table->string('slug', 250)->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable()->default('default.png'); // ảnh đại diện
            $table->boolean('status')->default(1); // trạng thái hiển thị
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};