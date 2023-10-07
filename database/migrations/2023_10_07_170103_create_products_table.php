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
            $table->unsignedBigInteger('product_line_id');
            $table->string('name', '150')
                ->unique()
                ->nullable(false);
            $table->float('scale')->nullable(false);
            $table->string('vendor', '100')->nullable(false);
            $table->text('description')->nullable(false);
            $table->integer('quantity_in_stock')->nullable(false);
            $table->float('buy_price')->nullable(false);
            $table->float('msrp')->nullable(false);

            $table->foreign('product_line_id')->references('id')->on('product_lines');
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
