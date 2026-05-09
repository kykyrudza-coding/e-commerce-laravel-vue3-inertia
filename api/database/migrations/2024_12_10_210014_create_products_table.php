<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name')
                ->unique();
            $table->text('description');
            $table->decimal('price', 10);
            $table->integer('stock')
                ->default(0);
            $table->string('slug')
                ->unique();
            $table->unsignedBigInteger('brand_id')
                ->nullable();
            $table->float('screen_size_id')
                ->nullable();
            $table->unsignedBigInteger('screen_type_id')
                ->nullable();
            $table->unsignedBigInteger('os_id')
                ->nullable();
            $table->unsignedBigInteger('processor_id')
                ->nullable();
            $table->unsignedBigInteger('ram_id')
                ->nullable();
            $table->unsignedBigInteger('storage_id')
                ->nullable();
            $table->unsignedBigInteger('camera_resolution_id')
                ->nullable();
            $table->unsignedBigInteger('battery_capacity_id')
                ->nullable();
            $table->unsignedBigInteger('color_id')
                ->nullable();
            $table->unsignedBigInteger('condition_id')
                ->nullable();
            $table->timestamps();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('set null');

            $table->foreign('screen_type_id')
                ->references('id')
                ->on('screen_types')
                ->onDelete('set null');

            $table->foreign('os_id')
                ->references('id')
                ->on('operating_systems')
                ->onDelete('set null');

            $table->foreign('processor_id')
                ->references('id')
                ->on('processors')
                ->onDelete('set null');

            $table->foreign('ram_id')
                ->references('id')
                ->on('ram')
                ->onDelete('set null');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('storage_id')
                ->references('id')
                ->on('storage')
                ->onDelete('set null');

            $table->foreign('camera_resolution_id')
                ->references('id')
                ->on('camera_resolution')
                ->onDelete('set null');

            $table->foreign('battery_capacity_id')
                ->references('id')
                ->on('battery_capacity')
                ->onDelete('set null');

            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('set null');

            $table->foreign('condition_id')
                ->references('id')
                ->on('conditions')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
