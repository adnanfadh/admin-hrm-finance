<?php

namespace Database\Seeders;

use App\Models\Finance\RulesJurnalInput;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\Types\Null_;

class RulesJurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        $data = [
            [
                'rules_jurnal_category'         => 4,
                'rules_jurnal_category_2'       => 1,
                'rules_jurnal_name'             => 'Kirim Uang',
                'rules_jurnal_keterangan'       => 'Transaksi untuk kirim uang',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => null,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 5,
                'rules_jurnal_category_2'       => 1,
                'rules_jurnal_name'             => 'Terima Uang',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Terima uang',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => null,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 3,
                'rules_jurnal_category_2'       => 1,
                'rules_jurnal_name'             => 'Biaya',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Biaya',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => null,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 3,
                'rules_jurnal_category_2'       => 2,
                'rules_jurnal_name'             => 'Biaya Bayar Nanti',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Biaya Bayar Nanti',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => 37,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 3,
                'rules_jurnal_category_2'       => 3,
                'rules_jurnal_name'             => 'Bayar Biaya',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Bayar Biaya',
                'rules_jurnal_akun_debit'       => 30,
                'rules_jurnal_akun_kredit'      => null,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 2,
                'rules_jurnal_category_2'       => 1,
                'rules_jurnal_name'             => 'Pembelian Order',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Order Pembelian',
                'rules_jurnal_akun_debit'       => 70,
                'rules_jurnal_akun_kredit'      => 37,
                'rules_jurnal_akun_discount'    => 66,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 2,
                'rules_jurnal_category_2'       => 2,
                'rules_jurnal_name'             => 'Pembelian Cash',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Pembelian Cash',
                'rules_jurnal_akun_debit'       => 70,
                'rules_jurnal_akun_kredit'      => null,
                'rules_jurnal_akun_discount'    => 66,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 2,
                'rules_jurnal_category_2'       => 3,
                'rules_jurnal_name'             => 'Bayar Pembelian',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Bayar Pembelian',
                'rules_jurnal_akun_debit'       => 37,
                'rules_jurnal_akun_kredit'      => null,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 1,
                'rules_jurnal_category_2'       => 1,
                'rules_jurnal_name'             => 'Penjualan Jasa Order',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Order Penjualan Jasa',
                'rules_jurnal_akun_debit'       => 8,
                'rules_jurnal_akun_kredit'      => 68,
                'rules_jurnal_akun_discount'    => 66,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 1    ,
                'rules_jurnal_category_2'       => 2,
                'rules_jurnal_name'             => 'Penjualan Jasa Cash',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Penjualan Jasa Cash',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => 68,
                'rules_jurnal_akun_discount'    => 66,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 1,
                'rules_jurnal_category_2'       => 3,
                'rules_jurnal_name'             => 'Bayar Penjualan Jasa',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Bayar Penjualan Jasa',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => 8,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 1,
                'rules_jurnal_category_2'       => 4,
                'rules_jurnal_name'             => 'Penjualan Barang Order',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Order Penjualan Barang',
                'rules_jurnal_akun_debit'       => 8,
                'rules_jurnal_akun_kredit'      => 64,
                'rules_jurnal_akun_discount'    => 66,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 1,
                'rules_jurnal_category_2'       => 5,
                'rules_jurnal_name'             => 'Penjualan Barang Cash',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Penjualan Barang Cash',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => 64,
                'rules_jurnal_akun_discount'    => 66,
                'rules_jurnal_akun_ppn'         => 47,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ],
            [
                'rules_jurnal_category'         => 1,
                'rules_jurnal_category_2'       => 6,
                'rules_jurnal_name'             => 'Bayar Penjualan Barang',
                'rules_jurnal_keterangan'       => 'Transaksi untuk Bayar Penjualan Barang',
                'rules_jurnal_akun_debit'       => null,
                'rules_jurnal_akun_kredit'      => 9,
                'rules_jurnal_akun_discount'    => null,
                'rules_jurnal_akun_ppn'         => null,
                'creat_by'          => 1,
                'creat_by_company'  => 1
            ]
        ];

        foreach ($data as $d) {
            RulesJurnalInput::create([
                'rules_jurnal_category'         => $d['rules_jurnal_category'], 
                'rules_jurnal_category_2'       => $d['rules_jurnal_category_2'],
                'rules_jurnal_name'             => $d['rules_jurnal_name'], 
                'rules_jurnal_keterangan'       => $d['rules_jurnal_keterangan'],
                'rules_jurnal_akun_debit'       => $d['rules_jurnal_akun_debit'], 
                'rules_jurnal_akun_kredit'      => $d['rules_jurnal_akun_kredit'],
                'rules_jurnal_akun_discount'    => $d['rules_jurnal_akun_discount'], 
                'rules_jurnal_akun_ppn'         => $d['rules_jurnal_akun_ppn'],
                'creat_by'  => $d['creat_by'],
                'creat_by_company'  => $d['creat_by_company'],
            ]);
       }
    }
}
