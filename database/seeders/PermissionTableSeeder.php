<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'          => 'rolesManagement-list',
                'keterangan'    => 'Melihat list roles'
            ],
            [
                'name'          => 'rolesManagement-create',
                'keterangan'    => 'Membuat roles baru' 
            ],
            [
                'name'          => 'rolesManagement-edit',
                'keterangan'    => 'Merubah roles'
            ],
            [
                'name'          => 'rolesManagement-delete',
                'keterangan'    => 'Menghapus roles'
            ],
            [
                'name'          => 'userroles-list',
                'keterangan'    => 'Melihat list user roles'
            ],
            [
                'name'          => 'userroles-create',
                'keterangan'    => 'Membuat user roles baru'
            ],
            [
                'name'          => 'userroles-edit',
                'keterangan'    => 'Merubah user roles'
            ],
            [
                'name'          => 'userroles-delete',
                'keterangan'    => 'Menghapus user roles'
            ],
            [
                'name'          => 'absen-list',
                'keterangan'    => 'Melihat list absen'
            ],
            [
                'name'          => 'absen-create',
                'keterangan'    => 'Membuat absen baru'
            ],
            [
                'name'          => 'absen-edit',
                'keterangan'    => 'Merubah absen'
            ],
            [
                'name'          => 'absen-delete',
                'keterangan'    => 'Menghapus absen'
            ],
            [
                'name'          => 'asset-list',
                'keterangan'    => 'Melihat list assets'
            ],
            [
                'name'          => 'asset-create',
                'keterangan'    => 'Membuat assets baru'
            ],
            [
                'name'          => 'asset-edit',
                'keterangan'    => 'Merubah assets'
            ],
            [
                'name'          => 'asset-delete',
                'keterangan'    => 'Menghapus assets'
            ],
            [
                'name'          => 'departement-list',
                'keterangan'    => 'Melihat list departement'
            ],
            [
                'name'          => 'departement-create',
                'keterangan'    => 'Membuat departement baru'
            ],
            [
                'name'          => 'departement-edit',
                'keterangan'    => 'Merubah departement'
            ],
            [
                'name'          => 'departement-delete',
                'keterangan'    => 'Menghapus departement'
            ],
            [
                'name'          => 'jabatan-list',
                'keterangan'    => 'Melihat list jabatan'
            ],
            [
                'name'          => 'jabatan-create',
                'keterangan'    => 'Membuat jabatan baru'
            ],
            [
                'name'          => 'jabatan-edit',
                'keterangan'    => 'Merubah jabatan'
            ],
            [
                'name'          => 'jabatan-delete',
                'keterangan'    => 'Menghapus jabatan'
            ],
            [
                'name'          => 'bpjs-list',
                'keterangan'    => 'Melihat list bpjs'
            ],
            [
                'name'          => 'bpjs-create',
                'keterangan'    => 'Membuat bpjs baru'
            ],
            [
                'name'          => 'bpjs-edit',
                'keterangan'    => 'Merubah bpjs'
            ],
            [
                'name'          => 'bpjs-delete',
                'keterangan'    => 'Menghapus bpjs'
            ],
            [
                'name'          => 'client-list',
                'keterangan'    => 'Melihat list client'
            ],
            [
                'name'          => 'client-create',
                'keterangan'    => 'Membuat client baru'
            ],
            [
                'name'          => 'client-edit',
                'keterangan'    => 'Merubah client'
            ],
            [
                'name'          => 'client-delete',
                'keterangan'    => 'Menghapus client'
            ],
            [
                'name'          => 'cuti-list',
                'keterangan'    => 'Melihat list cuti'
            ],
            [
                'name'          => 'cuti-create',
                'keterangan'    => 'Membuat cuti baru'
            ],
            [
                'name'          => 'cuti-edit',
                'keterangan'    => 'Merubah cuti'
            ],
            [
                'name'          => 'cuti-delete',
                'keterangan'    => 'Menghapus cuti'
            ],
            [
                'name'          => 'gaji-list',
                'keterangan'    => 'Melihat list gaji'
            ],
            [
                'name'          => 'gaji-create',
                'keterangan'    => 'Membuat gaji baru'
            ],
            [
                'name'          => 'gaji-edit',
                'keterangan'    => 'Merubah gaji'
            ],
            [
                'name'          => 'gaji-delete',
                'keterangan'    => 'Menghapus gaji'
            ],
            [
                'name'          => 'kebijakan-list',
                'keterangan'    => 'Melihat list kebijakan'
            ],
            [
                'name'          => 'kebijakan-create',
                'keterangan'    => 'Membuat kebijakan baru'
            ],
            [
                'name'          => 'kebijakan-edit',
                'keterangan'    => 'Merubah kebijakan'
            ],
            [
                'name'          => 'kebijakan-delete',
                'keterangan'    => 'Menghapus kebijakan'
            ],
            [
                'name'          => 'lembur-list',
                'keterangan'    => 'Melihat list lembur'
            ],
            [
                'name'          => 'lembur-create',
                'keterangan'    => 'Membuat lembur baru'
            ],
            [
                'name'          => 'lembur-edit',
                'keterangan'    => 'Merubah lembur'
            ],
            [
                'name'          => 'lembur-delete',
                'keterangan'    => 'Menghapus lembur'
            ],
            [
                'name'          => 'overtime-list',
                'keterangan'    => 'Melihat list request overtime'
            ],
            [
                'name'          => 'overtime-create',
                'keterangan'    => 'Membuat request overtime baru'
            ],
            [
                'name'          => 'overtime-edit',
                'keterangan'    => 'Merubah request overtime'
            ],
            [
                'name'          => 'overtime-delete',
                'keterangan'    => 'Menghapus request overtime'
            ],
            [
                'name'          => 'pegawai-list',
                'keterangan'    => 'Melihat list pegawai'
            ],
            [
                'name'          => 'pegawai-create',
                'keterangan'    => 'Membuat pegawai baru'
            ],
            [
                'name'          => 'pegawai-edit',
                'keterangan'    => 'Merubah pegawai'
            ],
            [
                'name'          => 'pegawai-delete',
                'keterangan'    => 'Menghapus pegawai'
            ],
            [
                'name'          => 'pengumumanhr-list',
                'keterangan'    => 'Melihat list pengumuman HRD'
            ],
            [
                'name'          => 'pengumumanhr-create',
                'keterangan'    => 'Membuat pengumuman HRD baru'
            ],
            [
                'name'          => 'pengumumanhr-edit',
                'keterangan'    => 'Merubah pengumuman HRD'
            ],
            [
                'name'          => 'pengumumanhr-delete',
                'keterangan'    => 'Menghapus pengumuman HRD'
            ],
            [
                'name'          => 'pegawaiexit-list',
                'keterangan'    => 'Melihat list pegawai exit'
            ],
            [
                'name'          => 'pegawaiexit-create',
                'keterangan'    => 'Membuat pegawai exit baru'
            ],
            [
                'name'          => 'pegawaiexit-edit',
                'keterangan'    => 'Merubah pegawai exit'
            ],
            [
                'name'          => 'pegawaiexit-delete',
                'keterangan'    => 'Menghapus pegawai exit'
            ],
            [
                'name'          => 'penilaiankerja-list',
                'keterangan'    => 'Melihat list penilaian kerja'
            ],
            [
                'name'          => 'penilaiankerja-create',
                'keterangan'    => 'Membuat penilaian kerja baru'
            ],
            [
                'name'          => 'penilaiankerja-edit',
                'keterangan'    => 'Merubah penilaian kerja'
            ],
            [
                'name'          => 'penilaiankerja-delete',
                'keterangan'    => 'Menghapus penilaian kerja'
            ],
            [
                'name'          => 'pinjaman-list',
                'keterangan'    => 'Melihat list pinjaman'
            ],
            [
                'name'          => 'pinjaman-create',
                'keterangan'    => 'Membuat pinjaman baru'
            ],
            [
                'name'          => 'pinjaman-edit',
                'keterangan'    => 'Merubah pinjaman'
            ],
            [
                'name'          => 'pinjaman-delete',
                'keterangan'    => 'Menghapus pinjaman'
            ],
            [
                'name'          => 'project-list',
                'keterangan'    => 'Melihat list project'
            ],
            [
                'name'          => 'project-create',
                'keterangan'    => 'Membuat project baru'
            ],
            [
                'name'          => 'project-edit',
                'keterangan'    => 'Merubah project'
            ],
            [
                'name'          => 'project-delete',
                'keterangan'    => 'Menghapus project'
            ],
            [
                'name'          => 'shift-list',
                'keterangan'    => 'Melihat list shift'
            ],
            [
                'name'          => 'shift-create',
                'keterangan'    => 'Membuat shift baru'
            ],
            [
                'name'          => 'shift-edit',
                'keterangan'    => 'Merubah shift'
            ],
            [
                'name'          => 'shift-delete',
                'keterangan'    => 'Menghapus shift'
            ],
            [
                'name'          => 'sp-list',
                'keterangan'    => 'Melihat list sp'
            ],
            [
                'name'          => 'sp-create',
                'keterangan'    => 'Membuat sp baru'
            ],
            [
                'name'          => 'sp-edit',
                'keterangan'    => 'Merubah sp'
            ],
            [
                'name'          => 'sp-delete',
                'keterangan'    => 'Menghapus sp'
            ],
            [
                'name'          => 'sppd-list',
                'keterangan'    => 'Melihat list sppd'
            ],
            [
                'name'          => 'sppd-create',
                'keterangan'    => 'Membuat sppd baru'
            ],
            [
                'name'          => 'sppd-edit',
                'keterangan'    => 'Merubah sppd'
            ],
            [
                'name'          => 'sppd-delete',
                'keterangan'    => 'Menghapus sppd'
            ],
            [
                'name'          => 'task-create',
                'keterangan'    => 'Membuat task baru'
            ],
            [
                'name'          => 'task-edit',
                'keterangan'    => 'Merubah task'
            ],
            [
                'name'          => 'task-delete',
                'keterangan'    => 'Menghapus task'
            ],
            [
                'name'          => 'accountbank-list',
                'keterangan'    => 'Melihat list account bank'
            ],
            [
                'name'          => 'accountbank-create',
                'keterangan'    => 'Membuat account bank baru'
            ],
            [
                'name'          => 'accountbank-edit',
                'keterangan'    => 'Merubah account bank'
            ],
            [
                'name'          => 'accountbank-delete',
                'keterangan'    => 'Menghapus account bank'
            ],
            [
                'name'          => 'biaya-list',
                'keterangan'    => 'Melihat list biaya'
            ],
            [
                'name'          => 'biaya-create',
                'keterangan'    => 'Membuat biaya baru'
            ],
            [
                'name'          => 'biaya-edit',
                'keterangan'    => 'Merubah biaya'
            ],
            [
                'name'          => 'biaya-delete',
                'keterangan'    => 'Menghapus biaya'
            ],
            [
                'name'          => 'categoryaccount-list',
                'keterangan'    => 'Melihat list category account'
            ],
            [
                'name'          => 'categoryaccount-create',
                'keterangan'    => 'Membuat category account baru'
            ],
            [
                'name'          => 'categoryaccount-edit',
                'keterangan'    => 'Merubah category account'
            ],
            [
                'name'          => 'categoryaccount-delete',
                'keterangan'    => 'Menghapus category account'
            ],
            [
                'name'          => 'customer-list',
                'keterangan'    => 'Melihat list customer'
            ],
            [
                'name'          => 'customer-create',
                'keterangan'    => 'Membuat customer baru'
            ],
            [
                'name'          => 'customer-edit',
                'keterangan'    => 'Merubah customer'
            ],
            [
                'name'          => 'customer-delete',
                'keterangan'    => 'Menghapus customer'
            ],
            [
                'name'          => 'daftarlainnya-list',
                'keterangan'    => 'Melihat list daftarlainnya'
            ],
            [
                'name'          => 'kontak-list',
                'keterangan'    => 'Melihat list kontak'
            ],
            [
                'name'          => 'laporan-list',
                'keterangan'    => 'Melihat list laporan'
            ],
            [
                'name'          => 'metodepembayaran-list',
                'keterangan'    => 'Melihat list metode pembayaran'
            ],
            [
                'name'          => 'metodepembayaran-create',
                'keterangan'    => 'Membuat metode pembayaran baru'
            ],
            [
                'name'          => 'metodepembayaran-edit',
                'keterangan'    => 'Merubah metode pembayaran'
            ],
            [
                'name'          => 'metodepembayaran-delete',
                'keterangan'    => 'Menghapus metode pembayaran'
            ],
            [
                'name'          => 'pajak-list',
                'keterangan'    => 'Melihat list pajak'
            ],
            [
                'name'          => 'pajak-create',
                'keterangan'    => 'Membuat pajak baru'
            ],
            [
                'name'          => 'pajak-edit',
                'keterangan'    => 'Merubah pajak'
            ],
            [
                'name'          => 'pajak-delete',
                'keterangan'    => 'Menghapus pajak'
            ],
            [
                'name'          => 'pembelian-list',
                'keterangan'    => 'Melihat list pembelian'
            ],
            [
                'name'          => 'pembelian-create',
                'keterangan'    => 'Membuat pembelian baru'
            ],
            [
                'name'          => 'pembelian-edit',
                'keterangan'    => 'Merubah pembelian'
            ],
            [
                'name'          => 'pembelian-delete',
                'keterangan'    => 'Menghapus pembelian'
            ],
            [
                'name'          => 'penjualan-list',
                'keterangan'    => 'Melihat list penjualan'
            ],
            [
                'name'          => 'penjualan-create',
                'keterangan'    => 'Membuat penjualan baru'
            ],
            [
                'name'          => 'penjualan-edit',
                'keterangan'    => 'Merubah penjualan'
            ],
            [
                'name'          => 'penjualan-delete',
                'keterangan'    => 'Menghapus penjualan'
            ],
            [
                'name'          => 'product-list',
                'keterangan'    => 'Melihat list product'
            ],
            [
                'name'          => 'product-create',
                'keterangan'    => 'Membuat product baru'
            ],
            [
                'name'          => 'product-edit',
                'keterangan'    => 'Merubah product'
            ],
            [
                'name'          => 'product-delete',
                'keterangan'    => 'Menghapus product'
            ],
            [
                'name'          => 'supplier-list',
                'keterangan'    => 'Melihat list supplier'
            ],
            [
                'name'          => 'supplier-create',
                'keterangan'    => 'Membuat supplier baru'
            ],
            [
                'name'          => 'supplier-edit',
                'keterangan'    => 'Merubah supplier'
            ],
            [
                'name'          => 'supplier-delete',
                'keterangan'    => 'Menghapus supplier'
            ],
            [
                'name'          => 'syaratpembayaran-list',
                'keterangan'    => 'Melihat list syarat pembayaran'
            ],
            [
                'name'          => 'syaratpembayaran-create',
                'keterangan'    => 'Membuat syarat pembayaran baru'
            ],
            [
                'name'          => 'syaratpembayaran-edit',
                'keterangan'    => 'Merubah syarat pembayaran'
            ],
            [
                'name'          => 'syaratpembayaran-delete',
                'keterangan'    => 'Menghapus syarat pembayaran'
            ],
            [
                'name'          => 'finance-list',
                'keterangan'    => 'Management Finance'
            ],
            [
                'name'          => 'kasbank-list',
                'keterangan'    => 'Management Kas & Bank'
            ],
            [
                'name'          => 'company-list',
                'keterangan'    => 'Melihat list company'
            ],
            [
                'name'          => 'company-create',
                'keterangan'    => 'Membuat company baru'
            ],
            [
                'name'          => 'company-edit',
                'keterangan'    => 'Merubah company'
            ],
            [
                'name'          => 'company-delete',
                'keterangan'    => 'Menghapus company'
            ],
        ]; 
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission['name'], 'keterangan' => $permission['keterangan']]);
         }
    }
}
