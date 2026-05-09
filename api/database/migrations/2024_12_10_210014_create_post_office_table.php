<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_office', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('region_id')
                ->nullable();
            $table->timestamps();

            $table->foreign('city_id')
                ->references('id')
                ->on('city');
            $table->foreign('region_id')
                ->references('id')
                ->on('region');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_office');
    }
};
