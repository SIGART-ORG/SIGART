<?php

namespace App\Http\Controllers;

use App\Models\ServiceAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceAttachmentController extends Controller
{
    public function approved( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se puede realizar la operación.'
        ];

        $user = Auth::user();
        $id = $request->id ? $request->id : 0;
        $attachment = ServiceAttachment::find( $id );

        if( $attachment && $attachment->status === 1 && $attachment->is_valid === 0 ) {
            $attachment->is_valid = 1;
            $attachment->code_validation = $this->generateCode();
            $attachment->user_valid = $user->id;

            if( $attachment->save() ) {
                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }

        return response()->json( $response, 200 );
    }

    public function invalid( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se puede realizar la operación.'
        ];

        $user = Auth::user();
        $id = $request->id ? $request->id : 0;
        $attachment = ServiceAttachment::find( $id );

        if( $attachment && $attachment->status === 1 && $attachment->is_valid === 0 ) {
            $attachment->is_valid = 2;
            $attachment->user_valid = $user->id;

            if( $attachment->save() ) {
                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }

        return response()->json( $response, 200 );
    }

    private function generateCode() {
        $date = time();
        $token = $this->getToken( 20, $date );

        $exist = ServiceAttachment::where( 'code_validation', $token )->exists();
        if( $exist ) {
            $this->generateCode();
        }

        return $token;
    }

    private function getToken( $length, $seed) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";

        mt_srand( $seed );

        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }
        return $token;
    }
}
