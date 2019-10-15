<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
      'type', 'client_name', 'client_phone', 'residential_complex_id', 'layout_id', 'comment', 'popup_type'
    ];


    public function setClientPhoneAttribute($value)
    {
        $this->attributes['client_phone'] = preg_replace("/[^0-9]/", "", $value);
    }


    public function layout()
    {
        return $this->belongsTo('App\Layout');
    }
    public function residentialComplex()
    {
        return $this->belongsTo(ResidentialComplex::class, 'residential_complex_id', 'id');
    }


    public function getFormattedClientPhone()
    {
        $strLen = mb_strlen($this->client_phone);
        if ($strLen == 11) {
            return '+' . substr($this->client_phone, 0, 1)
              . ' (' . substr($this->client_phone, 1, 3) . ') '
              . substr($this->client_phone, 4, 3)
              . '-' . substr($this->client_phone, 7);
        } elseif ($strLen == 10) {
            return '+7 (' . substr($this->client_phone, 0, 3) . ') '
              . substr($this->client_phone, 3, 3)
              . '-' . substr($this->client_phone, 6);
        } else {
            return $this->client_phone;
        }
    }
}
