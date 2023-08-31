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
            $table->bigInteger('user_id')->unsigned();
            $table->string('number');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->string('payment_type')->nullable();
            $table->enum('payment_status', ['1', '2', '3', '4', '5'])->comment('1=pending, 2=success, 3=expired, 4=cancelled, 5=deny/failure');
            $table->string('payment_url')->nullable();
            $table->text('delivery_address')->nullable();
            $table->timestamps();

            $table->foreign('user_id', 'user_id_foreign')->references('id')->on('users');
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
