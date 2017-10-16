<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartmentsRange extends Model
{
    public function getPriceRange()
    {
        return ($this->price_min == $this->price_max)
            ? number_format($this->price_min, 0, ',', ' ')
            : number_format($this->price_min, 0, ',', ' ') . ' - ' . number_format($this->price_max, 0, ',', ' ');
    }
}
