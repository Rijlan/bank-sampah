<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = [
            [
                'jenis' => 'kertas',
                'harga_nasabah' => 1000,
                'harga_pengepul' => 1400
            ],
            [
                'jenis' => 'plastik',
                'harga_nasabah' => 5000,
                'harga_pengepul' => 7000
            ],
            [
                'jenis' => 'logam',
                'harga_nasabah' => 6000,
                'harga_pengepul' => 8000
            ]
        ];

        DB::table('jenis_sampahs')->insert($jenis);
    }
}
