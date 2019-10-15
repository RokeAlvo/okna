<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property House $house
 */
class HouseMaterial extends Model
{
    protected $table = 'house_materials';

    public function house() {
        return $this->belongsToMany(House::class);
    }
}
