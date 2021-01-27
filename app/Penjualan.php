<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = ['nama_pengepul', 'alamat', 'telpon', 'jenis_sampah_id', 'berat', 'total'];

    public function getTotalAttribute()
    {
        // return $this->attributes['kredit'] = sprintf(number_format($kredit, 2));
        return number_format($this->attributes['total'], 0, ',', '.');
    
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
           ->format('d-M-Y');
    }
    
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])
           ->diffForHumans();
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }

    public function getTotalHargaAttribute()
    {
        return $this->attributes['total'];
    }
}
