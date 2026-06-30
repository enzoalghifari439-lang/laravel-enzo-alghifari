<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2);
            $table->dateTime('sale_date');
            $table->timestamps();

            $table->index('product_id');
            $table->index('customer_id');
            $table->index('sale_date');
            $table->index(['sale_date', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
