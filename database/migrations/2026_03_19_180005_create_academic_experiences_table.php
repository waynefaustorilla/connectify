<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('academic_experiences', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->string('school_name');
      $table->foreignId('education_level_id')->nullable()->constrained('education_levels')->nullOnDelete();
      $table->string('field_of_study')->nullable();
      $table->year('start_year');
      $table->year('end_year')->nullable();
      $table->text('description')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('academic_experiences');
  }
};
