<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\ROle;
use App\Models\MenuRoleCategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->define_menus();
    }

    private function define_menus()
    {
        View::composer('*', function($view)
        {
            
            $menus_based_on_role_category = collect($this->get_menu_based_on_role_category());

            $menus_parent = $menus_based_on_role_category->where('route','=','#')->sortBy('order');

            $sidebars = array();

            foreach($menus_parent as $menu)
            {
                $sidebars_child = $menus_based_on_role_category->where('parent_id','=',$menu['id'])->sortBy('order');

                $sidebars[] = [
                    'title' => $menu['title'],
                    'order' => $menu['order'],
                    'route' => $menu['route'],
                    'childs_count' => count($sidebars_child),
                    'childs' => $sidebars_child,
                    'icon' => $menu['icon']
                ];
            }

            $view->with('sidebars', $sidebars);
        });
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
