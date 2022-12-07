<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::create([
            'shift_name' => 'hrd_shift',
            'hari_kerja' => '["Senin","Kamis","Jumat"]'
        ]);
    }
}
