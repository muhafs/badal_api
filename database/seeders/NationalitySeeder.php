<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/nationalities.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Nationality::create([
                    'name' => str($data['0'])->title()->trim(),
                    'country_id' => $data['1']
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
