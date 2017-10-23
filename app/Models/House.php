<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    public function getQuarterLabel($type = 'short') {
        $this->quarter_label = !empty(QUARTERS[$type][$this->completion_decade]) ? QUARTERS[$type][$this->completion_decade] : '?';
        return $this->quarter_label;
    }
}
