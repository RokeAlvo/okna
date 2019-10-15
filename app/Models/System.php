<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    public function uploadCityBackground($image, $city)
    {
        $img = explode(',', $image);
        $format = str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $img[0]
        );
        $image = base64_decode($img[1]);
        $publicPath = \Storage::disk('back');

        $imageName = 'bg-' . htmlentities($city) . '.' . $format;
        $result = $publicPath->put('/img/' . $imageName, $image);

        if($result)
            return ['success' => true, 'result' => '/img/' . $imageName];
        else
            return ['success' => false, 'result' => 'Error while file uploading'];
    }
}
