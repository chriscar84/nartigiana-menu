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
        Schema::table('menus', function (Blueprint $table) {
			$table->string('background_image')->nullable();
			$table->string('background_color')->nullable();
			$table->string('primary_color')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
			$table->dropColumn(['background_image', 'background_color', 'primary_color']);
		});
    }
};
