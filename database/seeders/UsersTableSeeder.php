<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email'     => 'hrd@gmail.com',
            'password'  => Hash::make('hrd031100'),
            'pegawai_id' => 1,
            'username' => 'Hrd',
            'photo' => 'assets/dokumen/user/ayLdoPqWOR2zOZFhyHQ42j9Kq8jjTwq8tVZEQSXb.jpg'
        ]);
        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);


        $user2 = User::create([
            'email'     => 'user@gmail.com',
            'password'  => Hash::make('user031100'),
            'pegawai_id' => 2,
            'username' => 'User',
            'photo' => 'assets/dokumen/user/ayLdoPqWOR2zOZFhyHQ42j9Kq8jjTwq8tVZEQSXb.jpg'
        ]);
        $role2 = Role::create(['name' => 'User']);

        $permissions2 = Permission::pluck('id','id')->all();

        $role2->syncPermissions($permissions2);

        $user2->assignRole([$role2->id]);



        $user3 = User::create([
            'email'     => 'user2@gmail.com',
            'password'  => Hash::make('user031100'),
            'pegawai_id' => 3,
            'username' => 'User2',
            'photo' => 'assets/dokumen/user/ayLdoPqWOR2zOZFhyHQ42j9Kq8jjTwq8tVZEQSXb.jpg'
        ]);
        $role3 = Role::create(['name' => 'User2']);

        $permissions3 = Permission::pluck('id','id')->all();

        $role3->syncPermissions($permissions3);

        $user3->assignRole([$role3->id]);
    }
}
