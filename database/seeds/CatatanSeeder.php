<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catatan = [
            [
                'jenis_sampah_id' => 2,
                'user_id' => 7,
                'keterangan' => 1,
                'berat' => 2.5,
            ],
            [
                'jenis_sampah_id' => 1,
                'user_id' => 7,
                'keterangan' => 1,
                'berat' => 3,
            ],
            [
                'jenis_sampah_id' => 3,
                'user_id' => 7,
                'keterangan' => 1,
                'berat' => 2,
            ]
        ];

        DB::table('catatans')->insert($catatan);
    }
}
