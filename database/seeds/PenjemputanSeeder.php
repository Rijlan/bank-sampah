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
                'url_alamat' => 'kretek',
                'telpon' => '081357843467',
                'foto' => 'https://cdn-radar.jawapos.com/uploads/radarsurabaya/news/2020/09/29/pembuangan-sampah-plastik-di-wilayah-surabaya-utara-paling-mencemaskan_m_216423.jpg',
                'user_id' => 7,
                'penjemput_id' => 1,
                'status' => 1,
            ],
            [
                'nama' => 'faiz',
                'alamat' => 'kota',
                'url_alamat' => 'kretek',
                'telpon' => '081234567356',
                'foto' => 'https://cdn-radar.jawapos.com/uploads/radarsurabaya/news/2020/09/29/pembuangan-sampah-plastik-di-wilayah-surabaya-utara-paling-mencemaskan_m_216423.jpg',
                'user_id' => 7,
                'penjemput_id' => 2,
                'status' => 2,
            ],
            [
                'nama' => 'dian',
                'alamat' => 'kretek',
                'url_alamat' => 'piyungan',
                'telpon' => '082246754439',
                'foto' => 'https://cdn-radar.jawapos.com/uploads/radarsurabaya/news/2020/09/29/pembuangan-sampah-plastik-di-wilayah-surabaya-utara-paling-mencemaskan_m_216423.jpg',
                'user_id' => 7,
                'penjemput_id' => 2,
                'status' => 3,
            ],
            [
                'nama' => 'sama',
                'alamat' => 'kretek',
                'url_alamat' => 'sampaan',
                'telpon' => '081339537805',
                'foto' => 'https://cdn-radar.jawapos.com/uploads/radarsurabaya/news/2020/09/29/pembuangan-sampah-plastik-di-wilayah-surabaya-utara-paling-mencemaskan_m_216423.jpg',
                'user_id' => 7,
                'penjemput_id' => 1,
                'status' => 4,
            ],
        ];

        DB::table('penjemputans')->insert($penjemputan);
    }
}