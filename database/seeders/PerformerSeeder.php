<?php

namespace Database\Seeders;

use App\Models\Performer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerformerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/performers.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Performer::create([
                    'user_id' => $data['0'],
                    'nickname' => str($data['1'])->trim()->isEmpty() ? null : str($data['1'])->title()->squish(),
                    'bio' => str($data['2'])->trim()->isEmpty() ? null : str($data['1'])->ucfirst()->squish(),
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
