<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/currencies.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Currency::create([
                    'name' => str($data['0'])->title()->squish(),
                    'code' => str($data['1'])->upper()->trim(),
                    'country_id' => $data['2']
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
