<?php

namespace Database\Seeders;

use App\Models\Finance\MetodePembayaran;
use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'nama_metode'   => 'Kas Tunai',
                'account_bank'   => 1,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'nama_metode'   => 'Transper Bank',
                'account_bank'   => 3 ,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ]
        );
        foreach ($data as $d) {
            MetodePembayaran::create([
                'nama_metode'  => $d['nama_metode'],
                'account_bank'  => $d['account_bank'],
                'creat_by'  => $d['creat_by'],
                'creat_by_company'  => $d['creat_by_company'],
            ]);
        }
    }
}
