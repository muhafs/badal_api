<?php

namespace App\Http\Traits;

trait HasImage
{
    function uploadImage($request, $as, $disk = 'public')
    {
        // create unique filename
        $imageName = str($as)->upper() . '_' . time() . '.' . $request->image->extension();

        // store image in APP
        $request->file('image')->storeAs(str($as)->lower(), $imageName, $disk);

        return $imageName;
    }
}
