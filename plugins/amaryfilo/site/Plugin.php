<?php namespace amaryfilo\Site;

use Backend;
use System\Classes\PluginBase;

/**
 * site Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Основая страница',
            'description' => 'Основная страница сайта',
            'author'      => 'amaryfilo',
            'icon'        => 'icon-home'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'amaryfilo\Site\Components\Main' => 'main',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'amaryfilo.site.some_permission' => [
                'tab' => 'site',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        // return [
        //     'site' => [
        //         'label'       => 'Главная',
        //         'url'         => \Backend::url('amaryfilo/site/options'),
        //         'icon'        => 'icon-home',
        //         'order'       => 500,
        //         'sideMenu' => [
        //                 'options' => [
        //                     'label'       => 'Опции',
        //                     'icon'        => 'icon-home',
        //                     'url'         => \Backend::url('amaryfilo/site/options/update/1'),
        //                 ],
        //                 'services' => [
        //                     'label'       => 'Услуги',
        //                     'icon'        => 'icon-th-large',
        //                     'url'         => \Backend::url('amaryfilo/site/services'),
        //                 ],
        //                 'indicators' => [
        //                     'label'       => 'Показатели',
        //                     'icon'        => 'icon-th-list',
        //                     'url'         => \Backend::url('amaryfilo/site/indicators'),
        //                 ],
        //                 'approachs' => [
        //                     'label'       => 'Подход к рекламе',
        //                     'icon'        => 'icon-truck',
        //                     'url'         => \Backend::url('amaryfilo/site/approachs'),
        //                 ],
        //                 'works' => [
        //                     'label'       => 'Умеем работать',
        //                     'icon'        => 'icon-truck',
        //                     'url'         => \Backend::url('amaryfilo/site/works'),
        //                 ],
        //                 'instruments' => [
        //                     'label'       => 'Инструменты и технологии',
        //                     'icon'        => 'icon-truck',
        //                     'url'         => \Backend::url('amaryfilo/site/instruments'),
        //                 ]
        //         ]

        //     ]
        // ];

    }
}
