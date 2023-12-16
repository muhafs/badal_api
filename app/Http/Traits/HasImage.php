<?php

namespace App\Http\Traits;

trait HasImage
{
    function uploadImage($request, $folderName, $disk = 'public')
    {
        // create unique filename
        $imageName = str($folderName)->upper() . '_' . time() . '.' . $request->image->extension();

        // store image in APP
        $request->file('image')->storeAs(str($folderName)->lower(), $imageName, $disk);

        return $imageName;
    }
}
