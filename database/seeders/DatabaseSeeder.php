<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                AdminSeeder::class,
                LanguageSeeder::class,
                NewsSeeder::class,  
                CareerSeeder::class,
                JobTypesSeeder::class,
                ClientsSeeder::class,
                ContractTypesSeeder::class,
                ContractTypeDetailsSeeder::class,
                DeliveryModelsSeeder::class,
                CandidatesSeeder::class,
                LocationSeeder::class,
                CompanyProfileSeeder::class,
            ]
        );


    }
}