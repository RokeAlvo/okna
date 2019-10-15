<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class House extends Model
{
    public function material()
    {
        return $this->hasOne(HouseMaterial::class, 'id', 'house_material_id');
    }
    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class)->withTimestamps();
    }

    public function scopeAlreadyBuilt($q)
    {
        $currentDate = Carbon::now();
        return $q->where('completion_year', '<', $currentDate->year)
            ->orWhere(function ($q) use ($currentDate) {
                $q->where('completion_year', $currentDate->year)
                    ->where('completion_decade', '<', $currentDate->quarter);
            });
    }
    public function scopeBuiltBetween($q, array $completionDates)
    {
        $completionDateFrom = !empty($completionDates[0])
            ? array_filter([
                'year' => substr($completionDates[0], 0, 4),
                'quarter' => substr($completionDates[0], 4, 1)
            ])
            : null;
        $completionDateTo = !empty($completionDates[1])
            ? array_filter([
                'year' => substr($completionDates[1], 0, 4),
                'quarter' => substr($completionDates[1], 4, 1)
            ])
            : null;
        return $q->where(function ($q) use ($completionDateFrom, $completionDateTo) {
            if (!empty($completionDateFrom) && !empty($completionDateTo)) {
                if ($completionDateTo['year'] == -1) {
                    $q->alreadyBuilt();
                } else {
                    if ($completionDateFrom == $completionDateTo) {
                        $q->where('completion_year', $completionDateTo['year'])->where('completion_decade', $completionDateTo['quarter']);
                    } elseif ($completionDateFrom['year'] == -1) {
                        $q->where('completion_year', '<', $completionDateTo['year'])
                            ->orWhere(function ($q) use ($completionDateTo) {
                                $q->where('completion_year', $completionDateTo['year'])->where('completion_decade', '<=', $completionDateTo['quarter']);
                            });
                    } else {
                        //dd($completionDateFrom, $completionDateTo);
                        $q->where(function ($q) use ($completionDateFrom) {
                            $q->where('completion_year', $completionDateFrom['year'])->where('completion_decade', '>=', $completionDateFrom['quarter']);
                        })->orWhere(function ($q) use ($completionDateTo) {
                            $q->where('completion_year', $completionDateTo['year'])->where('completion_decade', '<=', $completionDateTo['quarter']);
                        })->orWhere(function ($q) use ($completionDateFrom, $completionDateTo) {
                            $q->whereBetween('completion_year', [$completionDateFrom['year'], $completionDateTo['year']]);
                        });
                    }
                }
            } elseif (!empty($completionDateFrom) && ($completionDateFrom['year'] != -1)) {
                $q->where('completion_year', '>', $completionDateFrom['year'])
                    ->orWhere(function ($q) use ($completionDateFrom) {
                        $q->where('completion_year', $completionDateFrom['year'])->where('completion_decade', '>=', $completionDateFrom['quarter']);
                    });
            } elseif (!empty($completionDateTo)) {
                if ($completionDateTo['year'] == -1) {
                    $q->alreadyBuilt();
                } else {
                    $q->where('completion_year', '<', $completionDateTo['year'])
                        ->orWhere(function ($q) use ($completionDateTo) {
                            $q->where('completion_year', $completionDateTo['year'])->where('completion_decade', '<=', $completionDateTo['quarter']);
                        });
                }
            }
            return $q;
        });
    }

    public function isAlreadyBuilt()
    {
        $nowDate = Carbon::now();
        return $this->completion_year < $nowDate->year || ($this->completion_year == $nowDate->year && $this->completion_decade < $nowDate->quarter);
    }

    public function getQuarterLabel($type = 'short')
    {
        $this->quarter_label = !empty(QUARTERS[$type][$this->completion_decade]) ? QUARTERS[$type][$this->completion_decade] : '';
        return $this->quarter_label;
    }
    public function getCompletionDate($type = 'short')
    {
        $this->completion_date = $this->getQuarterLabel($type) . ' ' . $this->completion_year;
        return $this->isAlreadyBuilt() ? 'Сдан' : $this->completion_date;
    }
    public function getCompletionDeadline($type = 'short')
    {
        return (!$this->isAlreadyBuilt())
            ? ['key' => $this->completion_year . $this->completion_decade, 'value' => $this->getQuarterLabel($type) . ' ' . $this->completion_year]
            : ['key' => -1, 'value' => 'Сдан'];
    }

    /**
     * Function for generating completion dates until {$deadline}
     * @return array|void
    */
    public static function generateCompletionDates()
    {
        $currentDate = Carbon::now();
        $deadline = $currentDate->copy()->addYears(5);
        $completionDateRange = [0 => ['key' => -1, 'value' => 'Сдан']];
        while (IntVal($currentDate->year . $currentDate->quarter) <= IntVal($deadline->year . $deadline->quarter)) {
            $completionDateRange[] = [
                'key' => IntVal($currentDate->year . $currentDate->quarter), 'value' => QUARTERS['short'][$currentDate->quarter] . ' ' . $currentDate->year
            ];
            $currentDate->addQuarter();
        }
        return $completionDateRange;
    }
}
