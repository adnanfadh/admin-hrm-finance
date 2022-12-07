<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HRMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BidangsTableSeeder::class,
            JabatansTableSeeder::class,
            PegawaisTableSeeder::class,
            CompanySeeder::class,
        ]);
    }
}
