<?php

namespace Core\Providers;

use Core\Helpers\HtmlMacros;
use Collective\Html\HtmlServiceProvider;
use Core\Helpers\FormMacros;

class MacroServiceProvider extends HtmlServiceProvider
{

    protected function registerHtmlBuilder()
    {
        $this->app->singleton('html', function ($app) {
            return new HtmlMacros($app['url'], $app['view']);
        });
    }

    protected function registerFormBuilder()
    {
        $this->app->singleton('form', function ($app) {
            $form = new FormMacros(
                $app['html'],
                $app['url'],
                $app['view'],
                $app['session.store']->token(),
                $app['request']
            );

            return $form->setSessionStore($app['session.store']);
        });
    }
}
