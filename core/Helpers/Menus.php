<?php

namespace Core\Helpers;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\Models\User;

class Menus
{
    protected $menus = [];

    public function pushMenu($menu)
    {
        $group = (int)$menu['group'] ?? null;
        $groupName = $menu['group_name'] ?? '';

        if ($groupName) {
            $this->menus[$group]['name'] = $groupName;
            $this->menus[$group]['child'][$menu['pos_child']] = $menu;
        } else {
            $this->menus[$group]['single'] = $menu;
        }
    }

    public function renders()
    {
        $this->pushMenu($this->menuProfile());
        ksort($this->menus);

        $view = view('core::_partials.sidebar_extends', [
            'menus' => $this->menus,
        ]);

        echo $view->render();
    }

    public function menuProfile()
    {
        $menu = [
            'group' => 7,
            'group_name' => '',
            'pos_child' => 0,
            'name' => 'プロフィール設定',
            'class' => User::class,
            'route' => 'cp.edit.user',
            'param' => ['user' => Auth::id()],
            'icon' => 'address-card',
        ];
        return $menu;
    }
}
