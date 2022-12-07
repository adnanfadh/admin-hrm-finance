<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangsTableSeeder extends Seeder
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
                'kode_bidang' => 'D#01',
                'nama' => 'Head Office'
            ],
            [
                'kode_bidang' => 'D#02',
                'nama' => 'IT'
            ],
            [
                'kode_bidang' => 'D#03',
                'nama' => 'Multimedia'
            ],
            [
                'kode_bidang' => 'D#04',
                'nama' => 'Construction & Architect'
            ],
            [
                'kode_bidang' => 'D#05',
                'nama' => 'Travel'
            ],
            [
                'kode_bidang' => 'D#06',
                'nama' => 'Trans'
            ],
            [
                'kode_bidang' => 'D#07',
                'nama' => 'Cafe'
            ],
            [
                'kode_bidang' => 'D#05',
                'nama' => 'Guesthouse'
            ]
        );

        foreach ($data as $d){
            Bidang::create([
                'kode_bidang'   => $d['kode_bidang'],
                'nama'          => $d['nama']
            ]);

        };
    }
}
