<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed $residential_complexes
 */
class Infrastructure extends Model
{
    protected $table = 'infrastructures';

    public $fillable = [
        'name', 'type', 'searchable'
    ];

    public function residentialComplexes() {
        return $this->belongsToMany('App\ResidentialComplex', 'infrastructure_residential_complex', 'res_complex_id', 'id', 'infrastructure_id');
    }

    public function scopeSearchable($q)
    {
        return $q->where('searchable', true);
    }

    public function isInternal()
    {
        return $this->type == 1;
    }
    public function isExternal()
    {
        return $this->type == 2;
    }

    public function scopeInternal($query) {
        return $query->where('type', 1);
    }
    public function scopeExternal($query) {
        return $query->where('type', 2);
    }

    public function getType()
    {
        return INFRASTRUCTURES[$this->type];
    }
}
