<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/addresses.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Address::create([
                    'address' => str($data['0'])->title()->squish(),
                    'postcode' => str($data['1'])->upper()->trim(),
                    'city_id' => $data['2'],
                    'user_id' => $data['3']
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
