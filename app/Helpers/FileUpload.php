<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    public function save_file($file, $folder): string
    {
        $image_name = date('Ymd_His').'_'.rand().'.'.$file->getClientOriginalExtension();
        $file->storeAs('uploads/'.$folder,$image_name,'public');
        return $image_name;

    }

    public function remove_file($path,$name): void
    {
        if($name == 'default.png'){
            return;
        }

        $file_path = public_path('storage/uploads/').$path.'/'.$name;
        if(file_exists($file_path)) {
            unlink($file_path);
        }
    }

}
