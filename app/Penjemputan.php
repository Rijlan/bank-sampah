<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    protected $fillable = ['status', 'nama', 'alamat', 'url_alamat','telpon', 'foto','user_id', 'penjemput_id'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function penjemput()
    {
        return $this->belongsTo(User::class);
    }
}
