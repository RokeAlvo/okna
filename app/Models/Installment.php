<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installments';

    public function getCreditPeriodRange($end = true)
    {
        return $this->credit_period_range =
            (!empty($this->credit_period_from) ? 'от ' . $this->credit_period_from . ' ' : '') .
            (!empty($this->credit_period_to) ? 'до ' . $this->credit_period_to . ' ' : '') .
            ($end && (!empty($this->credit_period_from) || !empty($this->credit_period_from)) ? 'месяцев' : '');
    }
}
