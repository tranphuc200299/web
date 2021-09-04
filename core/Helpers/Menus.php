<?php

namespace Core\Helpers;

class Menus
{
    protected $defaultMenus = [];
    protected $groups = [];

    public function pushMenu($menu)
    {
        if (!empty($menu['group'])) {
            $this->groups[$menu['group']][] = $menu;
        } else {
            $this->defaultMenus[] = $menu;
        }
    }

    public function renders()
    {
        $view = view('core::_partials.sidebar_extends', [
            'defaultMenus' => $this->defaultMenus,
            'groupsMenus' => $this->groups,
        ]);

        echo $view->render();
    }
}
