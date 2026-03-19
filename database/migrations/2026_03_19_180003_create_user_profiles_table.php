<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('user_profiles', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
      $table->foreignId('relationship_status_id')->nullable()->constrained('relationship_statuses')->nullOnDelete();
      $table->text('bio')->nullable();
      $table->string('hometown')->nullable();
      $table->string('current_city')->nullable();
      $table->string('website')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('user_profiles');
  }
};
