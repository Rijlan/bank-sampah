<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penjualan = [
            [
                'nama_pengepul' => 'muhammad',
                'alamat' => 'kretek',
                'telpon' => '081357843467',
                'jenis_sampah_id' => 1,
                'berat' => 2,
                'total' => 4800, 
            ],
            [
                'nama_pengepul' => 'faiz',
                'alamat' => 'kota',
                'telpon' => '081234567356',
                'jenis_sampah_id' => 2,
                'berat' => 1,
                'total' => 7000, 
            ],
            [
                'nama_pengepul' => 'dian',
                'alamat' => 'kretek',
                'telpon' => '082246754439',
                'jenis_sampah_id' => 2,
                'berat' => 3,
                'total' => 21000,
            ],
            [
                'nama_pengepul' => 'sama',
                'alamat' => 'kretek',
                'telpon' => '081339537805',
                'jenis_sampah_id' => 3,
                'berat' => 2,
                'total' => 16000,
            ],
        ];

        DB::table('penjualans')->insert($penjualan);
    }
}
