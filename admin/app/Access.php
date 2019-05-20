<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Page;
use App\User;

class Access extends Model
{
    protected $table = 'access';
    protected $fillable = ['role_id', 'page_id', 'status'];

    public function page(){
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function menu()
    {
        $user = Auth::user();
        return $this->join('pages', 'pages.id', '=', 'access.page_id')
            ->join('modules', 'modules.id', '=', 'pages.module_id')
            ->where('access.status', 1)
            ->where('access.role_id', $user->role_id)
            ->where('pages.status', 1)
            ->where('modules.status', 1)
            ->select(
                'access.id',
                'access.page_id',
                'pages.name AS page_name',
                'pages.module_id',
                'modules.name AS module_name',
                'modules.icon AS module_icon',
                'pages.url',
                'pages.view_panel')
            ->orderBy('modules.name', 'asc')
            ->orderBy('pages.name', 'asc')
            ->get()
            ->toArray();
    }

    public static function sideBar( $page = 0 )
    {
        $access = new Access();
        $data = $access->menu();
        $menu = [];
        foreach ($data as $row) {

            $selected = 0;
            if( $row['page_id'] == $page ){
                $selected = 1;
            }

            $key = array_search($row['module_id'], array_column($menu, 'id'));
            if ($key >= 0 and !is_bool($key)) {
                if( $menu[$key]['selected'] == 0 ){
                    $menu[$key]['selected'] = $selected;
                }
                $menu[$key]['pages'][] = [
                    'id' => $row['page_id'],
                    'name' => $row['page_name'],
                    'url' => $row['url'],
                    'view_panel' => $row['view_panel'],
                    'selected' => $selected
                ];
            } else {
                $pages = [];
                $pages[0] = [
                    'id' => $row['page_id'],
                    'name' => $row['page_name'],
                    'url' => $row['url'],
                    'view_panel' => $row['view_panel'],
                    'selected' => $selected
                ];
                $menu[] = [
                    'id' => $row['module_id'],
                    'name' => $row['module_name'],
                    'icon' => $row['module_icon'],
                    'pages' => $pages,
                    'selected' => $selected
                ];
            }
        }
        return $menu;
    }

    public static function permits($page){
        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);

        $permitController = true;

        if($user){
            $role = $user->role_id;

            if( $page == 13 and $role != 1){
                $permitController = false;
            }

            $permits = Access::where('role_id', $role)
                ->where('page_id', $page)
                ->where('status', 1)
                ->count();

            if( $permits > 0 and $permitController){
                return true;
            }
        }

        return false;
    }
}
