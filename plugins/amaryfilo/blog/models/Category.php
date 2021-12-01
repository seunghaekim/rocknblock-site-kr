<?php namespace Amaryfilo\Blog\Models;

use Model;

/**
 * Category Model
 */
class Category extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'amaryfilo_blog_categories';

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
        'articles_in' => [
            'Amaryfilo\Blog\Models\Article',
            'table' => 'amaryfilo_blog_key',
            'key'      => 'article_id',
            'otherKey' => 'category_id'
        ]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
