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
                    'name' => str($data['0'])->title()->squish(),
                    'nationality' => str($data['1'])->title()->squish(),
                    'currency_code' => str($data['2'])->upper()->trim(),
                    'phone_code' => $data['3'],
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
