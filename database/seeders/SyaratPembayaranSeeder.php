<?php

namespace Database\Seeders;

use App\Models\Finance\SyaratPembayaran;
use Illuminate\Database\Seeder;

class SyaratPembayaranSeeder extends Seeder
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
                'nama_syarat'   => 'Net 30',
                'jangka_waktu'   => 30,
                'account_bank'   => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'nama_syarat'   => 'Cash On Delivery',
                'jangka_waktu'   => 0,
                'account_bank'   => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'nama_syarat'   => 'Net 15',
                'jangka_waktu'   => 15,
                'account_bank'   => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'nama_syarat'   => 'Net 60',
                'jangka_waktu'   => 60,
                'account_bank'   => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
        );
        foreach ($data as $d) {
            SyaratPembayaran::create([
                'nama_syarat'   => $d['nama_syarat'],
                'jangka_waktu'  => $d['jangka_waktu'],
                'account_bank'  => $d['account_bank'],
                'creat_by'  => $d['creat_by'],
                'creat_by_company'  => $d['creat_by_company'],
            ]);
        }
    }
}
