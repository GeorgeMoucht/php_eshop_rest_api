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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->dateTime('order_date')->nullable();
            $table->dateTime('shipped_date')->nullable();
            // Status list:
            // 1. Pending: Order created but not yet approved or processed.
            // 2. Processing: Orders that are currently being processed by the system.
            // 3. Shipped: Orders that have been shipped to the customer but not yet delivered.
            // 4. Delivered: Orders that have been successfully delivered to the customer.
            // 5. Canceled: Orders that have been canceled by the customer or by the system
            // 6. On Hold: Orders that are temporarily on hold for some reason.
            // 7. Refunded: Orders for which a refund has been issued.
            // 8. Completed: Orders that have been successfully processed, shipped, and delivered. This can include
            //    various tasks like order review and feedback from the user.
            $table->string('status', '80')->default('Pending approval');
            $table->text('comments');

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
