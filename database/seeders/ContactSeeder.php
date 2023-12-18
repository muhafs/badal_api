<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path("local_db/contacts.csv"), 'r');

        $chaptersRow = true;
        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$chaptersRow) {
                Contact::create([
                    'user_id' => $data['0'],
                    'phone_code_id' => $data['1'],
                    'phone_number' => str($data['2'])->trim(),
                    'email' => str($data['3'])->trim()->isEmpty() ? null : str($data['3'])->lower()->trim(),
                    'whatsapp' => str($data['4'])->trim()->isEmpty() ? null : str($data['4'])->trim(),
                    'instagram' => str($data['5'])->trim()->isEmpty() ? null : str($data['5'])->lower()->trim(),
                    'facebook' => str($data['6'])->trim()->isEmpty() ? null : str($data['6'])->title()->squish(),
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
