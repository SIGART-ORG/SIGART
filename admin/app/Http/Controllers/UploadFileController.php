<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function upload( UploadFileRequest $request ) {

        $file = Input::file('file');
        $filename = $file->getClientOriginalName();
        $rel = $request->rel;

        switch ( $rel ) {
            case 'products':
                $path = storage_path().'/products/prueba/';
                break;
        }

        if(Storage::disk('uploads')->put($path.'/'.$filename,  File::get($file))) {
            $productsImage = new \App\ProductsImages();
            $productsImage->products_id = $request->relId;
            $productsImage->image_original = $filename;
            $productsImage->image_galery = $filename;
            $productsImage->image_admin = $filename;
            $productsImage->image_facebook = $filename;
            $productsImage->image_default = 0;
            $productsImage->save();

            return response()->json([
                'success' => true,
                'id' => $productsImage->id
            ], 200);
        }
        return response()->json([
            'success' => false
        ], 500);

    }
}
