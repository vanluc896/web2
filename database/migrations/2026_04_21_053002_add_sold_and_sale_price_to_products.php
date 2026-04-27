<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->integer('sold')->default(0)->after('price');
        $table->integer('sale_price')->nullable()->after('sold');
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['sold', 'sale_price']);
    });
}
};
