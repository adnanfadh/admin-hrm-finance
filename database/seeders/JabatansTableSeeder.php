<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatansTableSeeder extends Seeder
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
                'nama' => 'President Commissioner',
                'gaji'  => 0
            ],
            [
                'nama' => 'Commissioner',
                'gaji'  => 0
            ],
            [
                'nama' => 'Chief Executive Officer',
                'gaji'  => 0
            ],
            [
                'nama' => 'Chief Technologi Officer',
                'gaji'  => 0
            ],
            [
                'nama' => 'Chief Financial Officer',
                'gaji'  => 0
            ],
            [
                'nama' => 'Chief Operating Officer',
                'gaji'  => 0
            ],
            [
                'nama' => 'Manager',
                'gaji'  => 0
            ]
        );

        foreach ($data as $d){
            Jabatan::create([
                'nama' => $d['nama'],
                'gaji'  => $d['gaji']
            ]);
        }
    }
}
