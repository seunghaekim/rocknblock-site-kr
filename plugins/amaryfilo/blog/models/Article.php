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
}
