<?php namespace Amaryfilo\Feedbacks;

use Backend;
use System\Classes\PluginBase;

/**
 * feedbacks Plugin Information File
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
            'name'        => 'feedbacks',
            'description' => 'No description provided yet...',
            'author'      => 'Amaryfilo',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'amaryfilo.feedbacks::mail.request',
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
        return []; // Remove this line to activate

        return [
            'Amaryfilo\Feedbacks\Components\MyComponent' => 'myComponent',
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
            'amaryfilo.feedbacks.some_permission' => [
                'tab' => 'feedbacks',
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
        return []; // Remove this line to activate

        return [
            'feedbacks' => [
                'label'       => 'feedbacks',
                'url'         => Backend::url('amaryfilo/feedbacks/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['amaryfilo.feedbacks.*'],
                'order'       => 500,
            ],
        ];
    }
}
