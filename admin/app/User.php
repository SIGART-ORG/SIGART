<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public static function getUserSitesRoles( $user ) {

        $data = DB::table( 'user_sites' )
            ->join( 'roles', 'roles.id', '=', 'user_sites.roles_id' )
            ->join( 'sites', 'sites.id', '=', 'user_sites.sites_id' )
            ->where( 'user_sites.users_id', $user )
            ->where( 'user_sites.status', 1 )
            ->where( 'sites.status', 1 )
            ->where( 'roles.status', 1 )
            ->select(
                'user_sites.id',
                'user_sites.users_id',
                'user_sites.roles_id',
                'user_sites.default',
                'roles.name as role',
                'sites.name as site'
            )->orderBy( 'user_sites.default', 'desc' )->get();

        $response = [
            'data' => [],
            'default' => 0
        ];
        foreach ( $data as $item ) {

            $response['data'][] = $item;
            if( $item->default == 1 ) {
                $response['default'] = $item->id;
            }
        }

        return $response;
    }
}
