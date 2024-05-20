<?php

namespace App\Traits;

trait Helper
{

    function uploadImage($request)
    {
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            return $path;
        }
    }
}
