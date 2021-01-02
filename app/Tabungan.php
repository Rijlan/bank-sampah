<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $fillable = ['user_id', 'debit', 'kredit'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function catatan()
    {
        return $this->belongsTo(Catatan::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(jenisSampah::class);
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
