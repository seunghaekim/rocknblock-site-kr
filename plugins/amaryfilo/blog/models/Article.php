<?php namespace Amaryfilo\Blog\Models;

use Model;

/**
 * Article Model
 */
class Article extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'amaryfilo_blog_articles';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'article_category' => [
            'Amaryfilo\Blog\Models\Category',
            'table' => 'amaryfilo_blog_key',
            'key'      => 'category_id',
            'otherKey' => 'article_id'
        ],
        'similar_articles' => [
            'Amaryfilo\Blog\Models\Article',
            'table' => 'amaryfilo_article_key',
            'key'      => 's_article_id',
            'otherKey' => 'article_id'
        ]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'image_article' => 'System\Models\File',
        'seo_image' => 'System\Models\File',
    ];
    public $attachMany = [];


    public static function getMenuTypeInfo($type)
    {
        // получаем текущую тему сайта
        $theme = \Cms\Classes\Theme::getActiveTheme();

        $result = [
            'dynamicItems' => true,
            // выберем все страницы сайта:
            'cmsPages' => \Cms\Classes\Page::listInTheme($theme, true),
        ];

        return $result;
    }

    public static function resolveMenuItem($item, $url, $theme)
    {
        $result = [
            'items' => []
        ];

        $page = \Cms\Classes\Page::loadCached($theme, $item->cmsPage);
        $rows = self::orderBy('title')->where('is_active', 1)->get();

        foreach ($rows as $row) {
            $item = [
                // Название страницы в карте сайта
                'title' => $row->title,
                // URL страницы в карте сайта (напр. "/element/:slug")
                // Создаем URL с помощью хелпера url()
                'url'   => url($page->getBaseFileName(), ['slug' => $row->slug]),
                // Параметр lastmod в карте сайта
                'mtime' => $row->updated_at,
            ];

            $result['items'][] = $item;
        }

        return $result;
    }
}

