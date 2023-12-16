<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/provinces.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Province::create([
                    'name' => str($data['0'])->title()->squish(),
                    'country_id' => str($data['1'])->title()->squish(),
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
