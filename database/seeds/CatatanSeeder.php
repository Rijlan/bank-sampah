<?php

use Carbon\Carbon;
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
                'keterangan' => 2,
                'berat' => 2.5,
                'total' => 12500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'jenis_sampah_id' => 3,
                'user_id' => 7,
                'keterangan' => 1,
                'berat' => 2,
                'total' => 3500,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'jenis_sampah_id' => 1,
                'user_id' => 7,
                'keterangan' => 2,
                'berat' => 3,
                'total' => 3000,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'jenis_sampah_id' => 3,
                'user_id' => 7,
                'keterangan' => 2,
                'berat' => 2,
                'total' => 12000,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
        ];

        DB::table('catatans')->insert($catatan);
    }
}
