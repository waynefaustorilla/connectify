<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FriendshipStatus;

class FriendshipStatusSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $statuses = ['pending', 'accepted', 'declined', 'blocked'];

    foreach ($statuses as $status) {
      FriendshipStatus::firstOrCreate(['name' => $status]);
    }
  }
}
