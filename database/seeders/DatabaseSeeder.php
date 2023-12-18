<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            NationalitySeeder::class,
            CurrencySeeder::class,
            PhoneSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            AddressSeeder::class,
            ContactSeeder::class,
            SeekerSeeder::class,
            PerformerSeeder::class,
        ]);
    }
}
