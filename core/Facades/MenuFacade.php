<?php

namespace Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class MenuFacade
 * @package Core\Facades
 *
 * @method static \Core\Helpers\Menus pushMenu($menu)
 * @method static \Core\Helpers\Menus renders()
 *
 * @see Menus
 */
class MenuFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'menu';
    }
}
