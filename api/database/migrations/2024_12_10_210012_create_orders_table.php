<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('order_token')->unique();

            $table->decimal('total_price', 10)->default(0);
            $table->enum('status', [
                'pending',
                'paid',
                'shipped',
                'cancelled'
            ])->default('pending');

            $table->index('status', 'custom_orders_status_index');

            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();

            $table->text('notes')->nullable();

            $table->string('currency', 3)->default('USD');

            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('status');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
