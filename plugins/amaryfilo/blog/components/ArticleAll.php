<?php namespace Amaryfilo\Blog\Components;

use Cms\Classes\ComponentBase;
use Amaryfilo\Blog\Models\Article;

class ArticleAll extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Статьи - все',
            'description' => 'Выводит все статьи'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function ViewArticlesAll()
    {
        return Article::orderBy('id', 'desc')->get();
    }
}
