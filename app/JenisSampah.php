<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    protected $fillable = ['jenis', 'harga_nasabah', 'harga_pengepul'];


    public function catatan()
    {
        return $this->hasMany(Catatan::class);
    }
   
    public function tabungan()
    {
        return $this->hasMany(Tabungan::class);
    }
}
