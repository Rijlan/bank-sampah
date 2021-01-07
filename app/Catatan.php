<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    protected $fillable = ['jenis_sampah_id', 'keterangan', 'user_id', 'berat', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }

    public function tabungan()
    {
        return $this->hasMany(Tabungan::class);
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

}
