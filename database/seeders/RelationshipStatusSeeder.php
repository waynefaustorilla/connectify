<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RelationshipStatus;

class RelationshipStatusSeeder extends Seeder {
  public function run(): void {
    $statuses = [
      'single',
      'in a relationship',
      'engaged',
      'married',
      'divorced',
      'widowed',
      'it\'s complicated',
      'in an open relationship',
    ];

    foreach ($statuses as $status) {
      RelationshipStatus::firstOrCreate(['name' => $status]);
    }
  }
}
