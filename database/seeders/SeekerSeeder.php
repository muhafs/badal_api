<?php

namespace Database\Seeders;

use App\Models\Seeker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeekerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/seekers.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Seeker::create([
                    'user_id' => $data['0'],
                    'hajj_name' => trim($data['1']) ? str($data['1'])->title()->squish() : null,
                    'currency_id' => $data['2'],
                    'price' => $data['3'],
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
