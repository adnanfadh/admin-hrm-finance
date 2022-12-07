<?php

namespace Database\Seeders;

use App\Models\Finance\Pajak;
use Illuminate\Database\Seeder;

class PajakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pajak::create([
            'nama_pajak'    => 'PPN',
            'persentase'    => 5,
            'creat_by'          => 1,
            'creat_by_company'  => 1
        ]);
    }
}
