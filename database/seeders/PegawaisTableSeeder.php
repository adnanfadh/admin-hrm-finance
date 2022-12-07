<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pegawai::create([
            'nip'           => '0000 000 001',
            'kode_pegawai'  => 'P#000',
            'nama'          => 'ADMINISTRATOR',
            'tempat_lahir'  => 'bandung',
            'tanggal_lahir' => '2000-09-06',
            'jenis_kelamin' => 'laki-laki',
            'alamat'        => 'bandung',
            'status'        => 'belum kawin',
            'tlp'           => '082215778220',
            'bidang_id'     => 2,
            'jabatan_id'    => 4,
            'shift_id'      => 1,
            'company_id'    => 1,
            'ttd'           => 'assets/dokumen/pegawai/ic2qWblIr2U8wIv9PilRUSLpk77MOGgizTeEfgbe.jpg'
        ]);

        Pegawai::create([
            'nip'           => '0000 000 002',
            'kode_pegawai'  => 'P#002',
            'nama'          => 'User',
            'tempat_lahir'  => 'bandung',
            'tanggal_lahir' => '2000-09-06',
            'jenis_kelamin' => 'laki-laki',
            'alamat'        => 'bandung',
            'status'        => 'belum kawin',
            'tlp'           => '082215778220',
            'bidang_id'     => 1,
            'jabatan_id'    => 1,
            'shift_id'      => 1,
            'company_id'    => 1,
            'ttd'           => 'assets/dokumen/pegawai/ic2qWblIr2U8wIv9PilRUSLpk77MOGgizTeEfgbe.jpg'
        ]);


        Pegawai::create([
            'nip'           => '0000 000 003',
            'kode_pegawai'  => 'P#003',
            'nama'          => 'User2',
            'tempat_lahir'  => 'bandung',
            'tanggal_lahir' => '2000-09-06',
            'jenis_kelamin' => 'laki-laki',
            'alamat'        => 'bandung',
            'status'        => 'belum kawin',
            'tlp'           => '082215778220',
            'bidang_id'     => 1,
            'jabatan_id'    => 1,
            'shift_id'      => 1,
            'company_id'    => 2,
            'ttd'           => 'assets/dokumen/pegawai/ic2qWblIr2U8wIv9PilRUSLpk77MOGgizTeEfgbe.jpg'
        ]);
    }
}
