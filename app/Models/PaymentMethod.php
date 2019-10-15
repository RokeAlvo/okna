<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed $houses
 */
class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    public $fillable = [
        'name'
    ];

    public function houses()
    {
        return $this->belongsToMany('App\House');
    }

    public function scopeSearchable($q)
    {
        //@todo change scope with aliases when newcrm db will be in use
        return $q->whereIn('id', [1, 2, 4, 5, 6]);
    }

    public static function savePaymentTerms($request)
    {
        $residential = ResidentialComplex::findOrFail($request->res_id);

        $saveStatus = true;
        if (!empty($ti = array_filter($request->trade_in))) {
            $tradeIn = $residential->tradeIn()->firstOrNew([]);
            $tradeIn->fill($request->trade_in);
            $saveStatus = $tradeIn->save();
        } elseif ($residential->tradeIn()->exists()) {
            $residential->tradeIn()->delete();
        }
        if ($saveStatus && !empty($im = array_filter($request->installment))) {
            $installment = $residential->installment()->firstOrNew([]);
            $installment->fill($request->installment);
            $installment->credit_to_building_house = !empty($request->installment['credit_to_building_house']);
            $installment->save();
        }
        if ($saveStatus && !empty($mwif = array_filter($request->mortgage_wif))) {
            $mortgageWithoutInitialFee = $residential->mortgageWithoutInitialFee()->firstOrNew([]);
            $mortgageWithoutInitialFee->fill($request->mortgage_wif);
            $mortgageWithoutInitialFee->percent_from_initial_fee = !empty($request->mortgage_wif['percent_from_initial_fee'])
                ? $request->mortgage_wif['percent_from_initial_fee'] : 0;
            $mortgageWithoutInitialFee->save();
        }
        if ($saveStatus && !empty($ms = array_filter($request->mortgage_special))) {
            $mortgageOnSpecialTerms = $residential->mortgageOnSpecialTerms()->firstOrNew([]);
            $mortgageOnSpecialTerms->fill($request->mortgage_special);
            $mortgageOnSpecialTerms->save();
        }
        return $saveStatus;
    }
}
