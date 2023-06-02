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
        Schema::table('stories', function (Blueprint $table) {
            $table->boolean('featured')->default(false);
            $table->string('main_image')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('featured');
            $table->dropColumn('main_image');
            $table->dropColumn('plan_id');
            $table->dropColumn('price');
            $table->string('role')->nullable();
        });
    }
};
