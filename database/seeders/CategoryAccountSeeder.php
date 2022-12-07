<?php

namespace Database\Seeders;

use App\Models\Finance\CategoryAccount;
use Illuminate\Database\Seeder;

class CategoryAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = array(
        //     [
        //         'nomor_category_account'    => '1-10101',
        //         'nama_category_account'     => 'Akun Piutang'
        //     ],
        //     [
        //         'nomor_category_account'    => '1-10301',
        //         'nama_category_account'     => 'Aktiva Lancar Lainnya'
        //     ],
        //     [
        //         'nomor_category_account'    => '1-10001',
        //         'nama_category_account'     => 'Kas & Bank'
        //     ],
        //     [
        //         'nomor_category_account'    => '1-10201',
        //         'nama_category_account'     => 'Persediaan'
        //     ],
        //     [
        //         'nomor_category_account'    => '1-10701',
        //         'nama_category_account'     => 'Aktiva Tetap'
        //     ],
        //     [
        //         'nomor_category_account'    => '1-10801',
        //         'nama_category_account'     => 'Aktiva Lainnya'
        //     ],
        //     [
        //         'nomor_category_account'    => '1-10401',
        //         'nama_category_account'     => 'Depresiasi & Amortisasi'
        //     ],
        //     [
        //         'nomor_category_account'    => '2-20101',
        //         'nama_category_account'     => 'Akun Hutang'
        //     ],
        //     [
        //         'nomor_category_account'    => '2-20001',
        //         'nama_category_account'     => 'Kartu Kredit'
        //     ],
        //     [
        //         'nomor_category_account'    => '2-20201',
        //         'nama_category_account'     => 'Kewajiban Lancar Lainnya'
        //     ],
        //     [
        //         'nomor_category_account'    => '2-20701',
        //         'nama_category_account'     => 'Kewajiban Jangka Panjang'
        //     ],
        //     [
        //         'nomor_category_account'    => '3-30001',
        //         'nama_category_account'     => 'Ekuitas'
        //     ],
        //     [
        //         'nomor_category_account'    => '4-40101',
        //         'nama_category_account'     => 'Pendapatan'
        //     ],
        //     [
        //         'nomor_category_account'    => '7-70001',
        //         'nama_category_account'     => 'Pendapatan Lainnya'
        //     ],
        //     [
        //         'nomor_category_account'    => '5-50201',
        //         'nama_category_account'     => 'Harga Pokok Penjualan'
        //     ],
        //     [
        //         'nomor_category_account'    => '6-60201',
        //         'nama_category_account'     => 'Beban'
        //     ],
        //     [
        //         'nomor_category_account'    => '8-80001',
        //         'nama_category_account'     => 'Beban Lainnya'
        //     ]
        // );

        $data = array(
            array('nomor_category_account' => '1-10101','nama_category_account' => 'Akun Piutang','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '1-10301','nama_category_account' => 'Aktiva Lancar Lainnya','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '1-10001','nama_category_account' => 'Kas & Bank','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '1-10201','nama_category_account' => 'Persediaan','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '1-10701','nama_category_account' => 'Aktiva Tetap','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '1-10801','nama_category_account' => 'Aktiva Lainnya','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '1-10401','nama_category_account' => 'Depresiasi & Amortisasi','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '2-20101','nama_category_account' => 'Akun Hutang','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '2-20001','nama_category_account' => 'Kartu Kredit','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '2-20201','nama_category_account' => 'Kewajiban Lancar Lainnya','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '2-20701','nama_category_account' => 'Kewajiban Jangka Panjang','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '3-30001','nama_category_account' => 'Ekuitas','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '4-40101','nama_category_account' => 'Pendapatan','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '7-70001','nama_category_account' => 'Pendapatan Lainnya','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '5-50201','nama_category_account' => 'Harga Pokok Penjualan','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '6-60201','nama_category_account' => 'Beban','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '8-80001','nama_category_account' => 'Beban Lainnya','created_at' => '2022-01-13 11:06:07','updated_at' => '2022-01-13 11:06:07', 'creat_by_company' => '1'),
            array('nomor_category_account' => '1-16000','nama_category_account' => 'Aktiva Tidak Lancar','created_at' => '2022-02-17 09:09:21','updated_at' => '2022-02-17 09:09:21', 'creat_by_company' => '1'),
            array('nomor_category_account' => '2-23000','nama_category_account' => 'Kewajiban Tidak Lancar','created_at' => '2022-02-17 09:53:14','updated_at' => '2022-02-17 09:53:14', 'creat_by_company' => '1')
          );
        foreach ($data as $d) {
            CategoryAccount::create([
                'nomor_category_account'    => $d['nomor_category_account'],
                'nama_category_account'     => $d['nama_category_account'],
                'creat_by_company'     => $d['creat_by_company']
            ]);
        }
    }
}
