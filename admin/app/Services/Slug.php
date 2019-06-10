<?php


namespace App\Services;

use App\Presentation;
use App\Product;
use Illuminate\Support\Str as Str;

class Slug
{
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */

    public static function createSlug( $table, $title, $id = 0 ) {
        $slug = Str::slug( $title );

        $countSlug = self::getRelatedSlug( $table, $slug, $id );

        if( $countSlug > 0 ) {
            return $slug . '-' . $countSlug;
        }else{
            return $slug;
        }

        throw new \Exception( 'Cant not create a unique slug.');
    }

    public static function getRelatedSlug( $table, $slug, $id = 0 ){
        $response = 0;
        switch ( $table ) {
            case 'product':
                $response = Product::where( 'slug', $slug )
                    ->where( 'id', '<>', $id )
                    ->count();
                break;
            case 'presentation':
                $response = Presentation::where( 'slug', $slug )
                    ->where( 'id', '<>', $id )
                    ->count();
                break;
        }

        return $response;
    }
}