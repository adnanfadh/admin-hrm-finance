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
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionTableSeeder::class,
            BidangsTableSeeder::class,
            ShiftTableSeeder::class,
            JabatansTableSeeder::class,
            PegawaisTableSeeder::class,
            UsersTableSeeder::class,
            MetodePembayaranSeeder::class,
            SyaratPembayaranSeeder::class,
            CategoryAccountSeeder::class,
            PajakSeeder::class,
            AccountSeeder::class,
            CompanySeeder::class,
            RulesJurnalSeeder::class,
        ]);
    }
}
