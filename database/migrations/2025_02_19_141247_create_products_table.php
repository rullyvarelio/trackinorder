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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained(
                table: 'categories',
                indexName: 'products_category_id'
            )->onDelete('cascade');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->unsigned();
            $table->integer('stock')->unsigned();
            $table->enum('status', ['available', 'out of stock']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
