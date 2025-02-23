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
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained(
                table: 'products',
                indexName: 'stock_out_product_id'
            )->onDelete('cascade');
            $table->integer('quantity')->unsigned();
            $table->string('reason'); // Sold, Expired, Damaged, etc.
            $table->date('used_date');
            $table->string('token_order')->nullable(); // Sold, Expired, Damaged, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
