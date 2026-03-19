<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('notifications', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
      $table->string('type'); // like, comment, friend_request, follow
      $table->nullableMorphs('notifiable'); // polymorphic: post, comment, friendship, etc.
      $table->timestamp('read_at')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('notifications');
  }
};
