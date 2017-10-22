<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'type', 'client_phone', 'client_name', 'layout_id', 'comment'
    ];

    public function setClientPhoneAttribute($value)
    {
        $this->attributes['client_phone'] = preg_replace("/[^0-9]/", "", $value);
    }

    public function createIfNotExists($attributes) {
        foreach ($attributes as $attr) {

        }
    }


}
