<?php namespace Amaryfilo\Blog;

use Event;
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
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'blog-plugin-article' => 'Blog Article',
                // 'test-plugin-element' => 'Test Plugin Elements',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'blog-plugin-article') {
                return Models\Article::getMenuTypeInfo($type);
            }
            // elseif ($type == 'test-plugin-element') {
            //     return Models\Article::getMenuTypeInfo($type);
            // }
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'blog-plugin-article') {
                return Models\Article::resolveMenuItem($item, $url, $theme);
            }
            // elseif ($type == 'test-plugin-element') {
            //     return Models\Article::resolveMenuItem($item, $url, $theme);
            // }
        });
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
        // return []; // Remove this line to activate

        return [
            'amaryfilo.blog.some_permission' => [
                'tab' => 'blog',
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
            'blog' => [
                'label'       => 'Blog',
                'url'         => Backend::url('amaryfilo/blog/articles'),
                'icon'        => 'icon-book',
                'permissions' => ['amaryfilo.blog.*'],
                'order'       => 500,
                'sideMenu' => [
                    'articles' => [
                        'label'       => 'Статьи',
                        'icon'        => 'icon-list-alt',
                        'url'         => \Backend::url('amaryfilo/blog/articles'),
                    ],     
                    'category' => [
                        'label'       => 'Категории',
                        'icon'        => 'icon-list',
                        'url'         => \Backend::url('amaryfilo/blog/category'),
                    ], 
                ],
            ],
        ];
    }
}
