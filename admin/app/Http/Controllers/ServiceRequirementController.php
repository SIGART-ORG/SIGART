<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequirement;
use Illuminate\Http\Request;

class ServiceRequirementController extends Controller
{
    public function load( Request $request ) {
        $id = $request->id ? $request->id : 0;

        $records = ServiceRequirement::where( 'services_id', $id )
            ->whereNotIn( 'status', [0,2] )
            ->orderBy( 'created_at', 'desc' )
            ->paginate( self::PAGINATE );

        $requirements = [];

        foreach ( $records as $record ) {
            $row = new \stdClass();
            $row->id = $record->id;
            $row->name = $record->name;
            $row->stage = $record->stage;
            $row->register = $this->getDateComplete( $record->created_at );

            $requirements[] = $row;
        }

        return response()->json([
            'status' => true,
            'requirements' => $requirements,
            'pagination' => [
                'total' => $records->total(),
                'current_page' => $records->currentPage(),
                'per_page' => $records->perPage(),
                'last_page' => $records->lastPage(),
                'from' => $records->firstItem(),
                'to' => $records->lastItem()
            ],
        ], 200);
    }

    public function store( Request $request ) {

    }
}
