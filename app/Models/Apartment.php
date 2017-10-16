<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    public function layout()
    {
        return $this->belongsTo('App\Layout');
    }
}
