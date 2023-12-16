<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/cities.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                City::create([
                    'name' => str($data['0'])->title()->squish(),
                    'province_id' => str($data['1'])->title()->squish(),
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
