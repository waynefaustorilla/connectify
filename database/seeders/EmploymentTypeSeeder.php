<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploymentType;

class EmploymentTypeSeeder extends Seeder {
  public function run(): void {
    $types = [
      'full-time',
      'part-time',
      'self-employed',
      'freelance',
      'internship',
      'contract',
    ];

    foreach ($types as $type) {
      EmploymentType::firstOrCreate(['name' => $type]);
    }
  }
}
