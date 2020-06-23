<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\Mails;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Correo',
                'url' => route( 'mail.dashboard' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar();

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'component'     => 'mail'
        ]);
    }

    public function index( Request $request ) {

        $search = $request->search;

        $records = Mails::whereNotIn( 'status', [2] )
            ->orderBy( 'created_at', 'DESC' )
            ->search( $search )
            ->paginate( self::PAGINATE );

        $mails = [];
        foreach ( $records as $record ) {
            $row = new \stdClass();
            $row->id = $record->id;
            $row->subject = $record->subject;
            $row->from = $record->from ? $record->from : 'Automatic';
            $row->to = $record->to;
            $row->dateSend = $this->getDateComplete( $record->dateSend );
            $row->attach = $record->attach ? asset( $record->attach ) : false;
            $row->status = $record->status;

            $mails[] = $row;
        }

        return response()->json([
            'status' => true,
            'pagination' => [
                'total' => $records->total(),
                'current_page' => $records->currentPage(),
                'per_page' => $records->perPage(),
                'last_page' => $records->lastPage(),
                'from' => $records->firstItem(),
                'to' => $records->lastItem()
            ],
            'mails' => $mails
        ], 200);
    }

    public function details( Mails $mail ) {
        return response()->json([
            'status' => true,
            'mail' => [
                'from' => $mail->from,
                'to' => $mail->to,
                'subject' => $mail->subject,
                'dateSend' => $this->getDateComplete( $mail->dateSend ),
                'attach' => $mail->attach ? asset( $mail->attach ) : false,
                'preview' => route( 'mail.preview', ['mail' => $mail->id])
            ]
        ], 200);
    }

    public function preview( Mails $mail ) {

        return $mail->body;
    }
}
