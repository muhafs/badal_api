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
                    'email' => trim($data['3']) ? str($data['3'])->lower()->trim() : null,
                    'whatsapp' => trim($data['4']) ? str($data['4'])->trim() : null,
                    'instagram' => trim($data['5']) ? str($data['5'])->lower()->trim() : null,
                    'facebook' => trim($data['6']) ? str($data['6'])->title()->squish() : null
                ]);
            }
            $chaptersRow = false;
        }

        fclose($csvData);
    }
}
