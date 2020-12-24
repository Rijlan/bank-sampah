<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    //

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
           ->format('H-M-Y');
    }
    
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])
           ->diffForHumans();
    }
}
