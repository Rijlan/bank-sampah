<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    protected $fillable = ['nama', 'alamat', 'telpon', 'user_id', 'penjemput_id'];
}
