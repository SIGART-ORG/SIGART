<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Notificación',
                'url' => route( 'notification.dashboard' )
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
            'component'     => 'notification'
        ]);
    }

    public function index( Request $request ) {
        $user = Auth::user();

        $records = Notification::whereNotIn('status', [0, 2])
            ->where( 'direction', 1 )
            ->where( 'userTo', $user->id )
            ->orderBy( 'created_at', 'Desc' )
            ->paginate( self::PAGINATE );

        $notifications = [];
        foreach ( $records as $record ) {

            $customerFrom = $record->relCustomerFrom;
            $customerFromData = $this->getDataCustomerLogin( $customerFrom );

            $row = new \stdClass();
            $row->id = $record->id;
            $row->message = $record->message;
            $row->url = $record->url;
            $row->dateDelivery = $this->getDateComplete( $record->dateDelivery );
            $row->dateSeen = $this->getDateComplete( $record->dateSeen );
            $row->customerFrom = $customerFromData;

            $notifications[] = $row;
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
            'notifications' => $notifications
        ], 200);
    }

    public function lastNotifications() {
        $user = Auth::user();

        $records = Notification::whereNotIn('status', [0, 2])
            ->where( 'direction', 1 )
            ->where( 'userTo', $user->id )
            ->isNotSeen( true )
            ->orderBy( 'created_at', 'Desc' )
            ->limit(10)
            ->get();

        $notifications = [];
        foreach ( $records as $record ) {

            $customerFrom = $record->relCustomerFrom;
            $customerFromData = $this->getDataCustomerLogin( $customerFrom );

            $row = new \stdClass();
            $row->id = $record->id;
            $row->message = $record->message;
            $row->url = $record->url;
            $row->diff = $this->getDiferenceDateNot( $record->dateDelivery );
            $row->customerFrom = $customerFromData;
            $row->readLink = route( 'notification.read', [ 'notification' => $record->id ] );

            $notifications[] = $row;
        }

        return response()->json([
            'status' => true,
            'notifications' => $notifications
        ], 200);
    }

    public function readNotification( Notification $notification ) {
        $dateSeen = $notification->dateSeen;
        $redirect = $notification->url;
        $notification->dateSeen = date( 'Y-m-d H:i:s' );
        if( !$dateSeen ) {
            $notification->save();
        }

        return redirect( $redirect );;
    }
}
