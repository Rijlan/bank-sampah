<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjemputanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $penjemputan = [
            [
                'nama' => 'muhammad',
                'alamat' => 'kretek',
                'telpon' => '081357843467',
                'user_id' => 7,
                'penjemput_id' => 1,
                'status' => 1,
            ],
            [
                'nama' => 'faiz',
                'alamat' => 'kota',
                'telpon' => '081234567356',
                'user_id' => 7,
                'penjemput_id' => 2,
                'status' => 2,
            ],
            [
                'nama' => 'dian',
                'alamat' => 'piyungan',
                'telpon' => '082246754439',
                'user_id' => 7,
                'penjemput_id' => 2,
                'status' => 3,
            ],
            [
                'nama' => 'sama',
                'alamat' => 'sampaan',
                'telpon' => '081339537805',
                'user_id' => 7,
                'penjemput_id' => 1,
                'status' => 4,
            ],
        ];

        DB::table('penjemputans')->insert($penjemputan);
    }
}