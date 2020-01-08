<?php

namespace App\Http\Controllers;

use App\Models\PresentationImage;
use Illuminate\Http\Request;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function upload( UploadFileRequest $request ) {

        $file   = Input::file('file');
        $exten  = $file->getClientOriginalExtension();
        $relId  = $request->relId;
        $rel    = $request->rel;
        $filename = uniqid( substr( $rel, 0,4 ) . '-' ) . '.' . $exten;

        switch ( $rel ) {
            case 'products':
                $path = 'products/' . $relId . '/';
                break;
            case 'presentations':
                $path = 'presentations/' . $relId .'/';
        }

        if(Storage::disk('uploads')->put($path.'/'.$filename,  File::get($file))) {

            switch ( $rel ) {
                case 'products':
                    $image = new \App\ProductsImages();
                    $image->products_id     = $request->relId;
                    $image->image_original  = $filename;
                    $image->image_galery    = $filename;
                    $image->image_admin     = $filename;
                    $image->image_facebook  = $filename;
                    $image->image_default   = 0;
                    $image->save();
                    break;
                case 'presentations':
                    $image = new PresentationImage();
                    $image->presentation_id = $request->relId;
                    $image->image_original  = $filename;
                    $image->order           = 0;
                    $image->save();
                    break;
            }


            return response()->json([
                'success' => true,
                'id' => $image->id
            ], 200);
        }
        return response()->json([
            'success' => false
        ], 500);

    }
}
