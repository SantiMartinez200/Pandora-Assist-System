<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('logings', function (Blueprint $table) {
      $table->id();
      $table->string('user_name')->nullable();
      $table->string('action')->nullable();
      $table->string('ip')->nullable();
      $table->string('browser')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('logings');
  }
};
