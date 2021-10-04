<?php

namespace Core\Helpers;

class Menus
{
    protected $menus = [];

    public function pushMenu($menu)
    {
        if (!empty($menu['group'])) {
            $this->menus[$menu['group']][] = $menu;
        } else {
            $this->menus[] = $menu;
        }
    }

    public function renders()
    {
        $view = view('core::_partials.sidebar_extends', [
            'groupsMenus' => $this->menus,
        ]);

        echo $view->render();
    }
}
