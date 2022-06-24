<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\MenuRoleCategory;

class MenuController extends Controller
{
    public function index()
    {
        dd(Role::where('id',session('role'))->first());
        //dd($this->get_menu_based_on_role_category());
        //https://codepen.io/n3k1t/pen/OJMGgyq
        $data = Menu::where('route','#')->orderBy('order')->get();

        $menu = array();

        foreach($data as $item)
        {
            $child_menu = Menu::where('parent_id', '=', $item->id)->orderBy('order')->get();

            $menu[] = [
                'id' => $item->id,
                'title' => $item->title,
                'order' => $item->order,
                'route' => $item->route,
                'icon' => $item->icon,
                'children' => $child_menu
            ];
        }

        return view('menus.index', [
            'title' => 'Data Menu',
            'data' => $menu
        ]);
    }

    public function get_form_add()
    {
        return view('menus.form-add', [
            'title' => 'Tambah Menu'
        ]);
    }

    public function get_form_edit()
    {
        return view('menus.form-edit', [
            'title' => 'Ubah Menu'
        ]);
    }

    private function get_menu_based_on_role_category()
    {
        $role = session('role');
        $role_data = Role::where('id',$role)->first();
        $role_category = $role_data != null ? $role_data->catgeory : null;

        $menus_based_on_role_category = MenuRoleCategory::where('role_category_id', $role_category)->get();

        $menus_selection = array();

        foreach($menus_based_on_role_category as $menu)
        {
            $menu = Menu::where('id', $menu->menu_id)->first();

            if ($menu != null)
            {
                $menus_selection[] = [
                    'id' => $menu->id,
                    'title' => $menu->title,
                    'order' => $menu->order,
                    'route' => $menu->route,
                    'parent_id' => $menu->parent_id,
                    'icon' => $menu->icon
                ];
            }
        }

        return $menus_selection;
    }
}
