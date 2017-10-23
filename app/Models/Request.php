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


    public function getFormattedClientPhone()
    {
        return '+' . substr($this->client_phone, 0, 1)
            . ' (' . substr($this->client_phone, 1, 3) . ') '
            . substr($this->client_phone, 4, 3)
            . '-' . substr($this->client_phone, 7);
    }
}
