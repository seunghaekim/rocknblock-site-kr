<?php namespace Amaryfilo\Blog;

use Backend;
use System\Classes\PluginBase;

/**
 * blog Plugin Information File
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
            'name'        => 'Blog',
            'description' => 'Blog articles',
            'author'      => 'amaryfilo',
            'icon'        => 'icon-book'
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
        //return []; // Remove this line to activate

        return [
            'Amaryfilo\Blog\Components\Articles' => 'article',
            'Amaryfilo\Blog\Components\Articleall' => 'articleall',
            'Amaryfilo\Blog\Components\Articlepreview' => 'articlepreview',
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
            'amaryfilo.blog.some_permission' => [
                'tab' => 'blog',
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
        // return []; // Remove this line to activate

        return [
            'blog' => [
                'label'       => 'Blog',
                'url'         => Backend::url('amaryfilo/blog/articles'),
                'icon'        => 'icon-book',
                'permissions' => ['amaryfilo.blog.*'],
                'order'       => 500,
            ],
        ];
    }
}
