<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'telpon' => '0812345678910',
            'alamat' => 'Kantor',
            'foto' => 'https://littlesmilespa.org/wp-content/uploads/2016/08/person-placeholder.png',
            'role' => 5
        ]);
    }
}
