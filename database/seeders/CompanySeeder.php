<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
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
                'kode_company'   => '0132201',
                'nama_company' => 'Panca Wibawa Global',
                'email_company' => 'info@pancawibawaglobal.com',
                'npwp_company'  => '0763241',
                'telpon_company' => '080000',
                'alamat_company' => 'bandung',
                'logo_company'    => 'bandung.jpg',
            ],
            [
                'kode_company'   => '0132202',
                'nama_company' => 'Panca Narasi Digital',
                'email_company' => 'info@pancanarasidigital.com',
                'npwp_company'  => '0763241',
                'telpon_company' => '080000',
                'alamat_company' => 'bandung',
                'logo_company'    => 'bandung.jpg',
            ],
            [
                'kode_company'   => '0132203',
                'nama_company' => 'Panca Cipta Global',
                'email_company' => 'info@pancaciptaglobal.com',
                'npwp_company'  => '0763241',
                'telpon_company' => '080000',
                'alamat_company' => 'bandung',
                'logo_company'    => 'bandung.jpg',
            ],
            [
                'kode_company'   => '0132204',
                'nama_company' => 'Panca Travel Indonesia',
                'email_company' => 'info@pancatravelindonesia.com',
                'npwp_company'  => '0763241',
                'telpon_company' => '080000',
                'alamat_company' => 'bandung',
                'logo_company'    => 'bandung.jpg',
            ],
            [
                'kode_company'   => '0132205',
                'nama_company' => 'Panca Rasa Indonesia',
                'email_company' => 'info@pancarasaindonesia.com',
                'npwp_company'  => '0763241',
                'telpon_company' => '080000',
                'alamat_company' => 'bandung',
                'logo_company'    => 'bandung.jpg',
            ]
        );

        foreach ($data as $d){
            Company::create([
                'kode_company'      => $d['kode_company'],
                'nama_company'      => $d['nama_company'],
                'email_company'     => $d['email_company'],
                'npwp_company'      => $d['npwp_company'],
                'telpon_company'    => $d['telpon_company'],
                'alamat_company'    => $d['alamat_company'],
                'logo_company'      => $d['logo_company']
            ]);
        }
    }
}
