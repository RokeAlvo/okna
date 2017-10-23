<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'type', 'client_name', 'client_phone', 'layout_id', 'comment'
    ];


    public function setClientPhoneAttribute($value)
    {
        $this->attributes['client_phone'] = preg_replace("/[^0-9]/", "", $value);
    }


    public function layout()
    {
        return $this->belongsTo('App\Layout');
    }

}
