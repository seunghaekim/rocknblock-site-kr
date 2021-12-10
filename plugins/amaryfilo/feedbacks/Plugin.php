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
            'name'        => 'Feedbacks',
            'description' => 'Feedbacks from website',
            'author'      => 'Amaryfilo',
            'icon'        => 'icon-info'
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'amaryfilo.feedbacks::mail.request',
            'amaryfilo.feedbacks::mail.feedback',
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
        // return []; // Remove this line to activate

        return [
            'amaryfilo\Feedbacks\Components\Feedback' => 'feedback',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        // return []; // Remove this line to activate

        return [
            'amaryfilo.feedbacks.access' => [
                'tab' => 'feedbacks',
                'label' => 'Create/Delete/Edit'
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
        // return []; // Remove this line to activate

        return [
            'feedbacks' => [
                'label'       => 'Feedbacks',
                'url'         => Backend::url('amaryfilo/feedbacks/feedback'),
                'icon'        => 'icon-info',
                'permissions' => ['amaryfilo.feedbacks.*'],
                'order'       => 500,
            ],
        ];
    }
}
