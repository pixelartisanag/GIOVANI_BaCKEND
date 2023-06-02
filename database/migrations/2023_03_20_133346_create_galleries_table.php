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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('featured')->default(false);
            $table->string('main_image')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedDecimal('price', 8, 2)->nullable();
            $table->json('media_gallery')->nullable();
            $table->boolean('published')->default(false);
            $table->string('uri')->unique();
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
