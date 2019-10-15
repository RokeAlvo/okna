<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResidentialComplexGalleryImage extends Model
{
    protected $table = 'residential_complex_images';

    public $fillable = [
        'residential_complex_id', 'original', 'main', 'thumbnail'
    ];

    protected $city;

    protected $storagePath;

    function __construct() {
        $this->city = getUrlPathFirstPart(true);
        $this->storagePath = $this->city === 'nsk' ? '/storage/' : '/storage-prod/';
    }

    public function getOriginalAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . ResidentialComplex::RC_PATH . $this->residential_complex_id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getMainAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . ResidentialComplex::RC_PATH . $this->residential_complex_id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getThumbnailAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . ResidentialComplex::RC_PATH . $this->residential_complex_id . '/' . $value;
        } else {
            return $value;
        }
    }
}
