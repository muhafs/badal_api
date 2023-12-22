<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * first_name,
     * last_name,
     * gender,
     * birth_date,
     * image,
     * type,
     * nationality_id
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/users.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                User::create([
                    'first_name' => str($data['0'])->ucfirst()->trim(),
                    'last_name' => str($data['1'])->ucfirst()->trim(),
                    'gender' => str($data['2'])->upper()->trim(),
                    'birth_date' => Carbon::make($data['3'])->toDateString(),
                    'image' => trim($data['4']) ? str($data['4'])->trim() : null,
                    'type' => str($data['5'])->upper()->trim(),
                    'nationality_id' => $data['6'],
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
