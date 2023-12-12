<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/countries.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Country::create([
                    'name' => str()->title($data['0']),
                    'nationality' => str()->title($data['1']),
                    'currency_code' => str()->upper($data['2']),
                    'phone_code' => $data['3'],
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
