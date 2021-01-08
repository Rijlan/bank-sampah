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
                'foto' => 'https://iili.io/K88RSI.png',
                'harga_nasabah' => 2000,
                'harga_pengepul' => 2400
            ],
            [
                'jenis' => 'plastik',
                'foto' => 'https://iili.io/K88IPR.png',
                'harga_nasabah' => 5000,
                'harga_pengepul' => 7000
            ],
            [
                'jenis' => 'besi',
                'foto' => 'https://iili.io/K88AcN.png',
                'harga_nasabah' => 6000,
                'harga_pengepul' => 8000
            ]
        ];

        DB::table('jenis_sampahs')->insert($jenis);
    }
}
