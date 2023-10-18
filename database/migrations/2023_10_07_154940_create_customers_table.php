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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // Unique constraint to ensure one-to-one relationship
//            $table->unsignedBigInteger('shipping_id'); // Unique constraint to ensure one-to-one relationship
//            $table->unsignedBigInteger('billing_id'); // Unique constraint to ensure one-to-one relationship
            $table->string('contact_lastname', '45')
                ->nullable(false)
                ->unique();

            $table->string('contact_firstname', '45')
                ->nullable(false)
                ->unique();

            $table->string('phone', '45')
            ->unique()
            ->nullable(false);

            $table->string('address_line_1', '100')->nullable(false);
            $table->string('address_line_2', '100')->nullable(false);
            $table->string('city', '45')->nullable(false);
            $table->string('state', '45')->nullable(false);
            $table->string('postal_code', '10')->nullable(false);
            $table->string('country', '45')->nullable(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
