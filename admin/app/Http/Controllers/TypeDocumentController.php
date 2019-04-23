<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeDocument;

class TypeDocumentController extends Controller
{
    public function allRegister(Request $request) {

        if(!$request->ajax()) return redirect('/');

        $typeDocument = TypeDocument::where('status', 1)
                        ->orderBy('name', 'asc')
                        ->select('id', 'name')
                        ->get();

        return [
            'typeDocument' => $typeDocument
        ];
    }
}
