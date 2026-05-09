<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('city');
            $table->string('region');
            $table->string('street')
                        ->nullable();
            $table->string('house')
                        ->nullable();
            $table->string('post_office')
                        ->nullable();
            $table->string('postal_code')
                        ->nullable();
            $table->string('date')
                        ->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_address');
    }
};
