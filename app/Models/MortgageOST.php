<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MortgageOST extends Model
{
    const MIN_MORTGAGE_PERCENT = 9;

    protected $table = 'mortgage_on_special_terms';


}
