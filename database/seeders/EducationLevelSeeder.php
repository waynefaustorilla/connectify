<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationLevel;

class EducationLevelSeeder extends Seeder {
  public function run(): void {
    $levels = [
      'high school',
      'associate\'s degree',
      'bachelor\'s degree',
      'master\'s degree',
      'doctorate',
      'vocational',
      'other',
    ];

    foreach ($levels as $level) {
      EducationLevel::firstOrCreate(['name' => $level]);
    }
  }
}
