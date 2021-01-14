<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $fillable = ['user_id', 'debit', 'kredit'];

    public function getDebitAttribute()
    {
        // return $this->attributes['debit'] = sprintf(number_format($debit, 2));
        return number_format($this->attributes['debit'], 0, ',', '.');
    
    }

    public function getKreditAttribute()
    {
        // return $this->attributes['kredit'] = sprintf(number_format($kredit, 2));
        return number_format($this->attributes['kredit'], 0, ',', '.');
    
    }

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

    public function getDebitRawAttribute()
    {
        return $this->attributes['debit'];
    }

    public function getKreditRawAttribute()
    {
        return $this->attributes['kredit'];
    }
}
