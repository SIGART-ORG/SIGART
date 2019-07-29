<?php

namespace App\Http\Controllers;

use App\Models\PresentationImage;
use App\ProductsImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function gallery( Request $request ){
        if(!$request->ajax()) return redirect('/');
        $response = [];
        switch ( $request->rel ) {
            case 'products':
                $images = ProductsImages::where('status', 1)
                    ->where('products_id', $request->id)
                    ->select(
                        'id',
                        'products_id',
                        'image_admin',
                        'image_default'
                    )
                    ->get();
                break;
            case 'presentations':
                $images = PresentationImage::where('status', 1)
                    ->where( 'presentation_id', $request->id )
                    ->select(
                        'id',
                        'image_original as image_admin'
                    )
                    ->selectRaw(
                        '0 as image_default'
                    )
                    ->get();
                break;
        }

        if ( ! empty( $images ) ) {
            foreach ($images as $img) {
                $urImage = Storage::disk('uploads')
                    ->url( $request->rel . '/' . $request->id . '/' . $img->image_admin);

                $row = new \stdClass();
                $row->id = $img->id;
                $row->image_admin = $img->image_admin;
                $row->image_default = $img->image_default;
                $row->image = $urImage;
                $response[] = $row;
            }
        }

        return response()->json([
            'gallery' => $response
        ]);
    }

    public function delete( Request $request ) {
        if(!$request->ajax()) return redirect('/');

        $status = false;

        switch ( $request->rel ) {
            case 'products':
                $image = ProductsImages::findOrFail( $request->id );
                $image->status = 2;
                if( $image->save() ) {
                    $status = true;
                }
                break;
            case 'presentations':
                $image = PresentationImage::findOrFail( $request->id );
                $image->status = 2;
                if( $image->save() ) {
                    $status = true;
                }
                break;
        }

        return response()->json([
            'status' => $status
        ]);
    }
}
