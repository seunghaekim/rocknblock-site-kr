<?php namespace Amaryfilo\Blog\Components;

use Cms\Classes\ComponentBase;
use Amaryfilo\Blog\Models\Article;

class ArticlePreview extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Статьи',
            'description' => 'Выводит определенное количество статей'
        ];
    }

    public function defineProperties()
    {
        return [
            'maxItems' => [
                'title'       => 'Введите количество выводимых отзывов',
                'description' => 'Введите 0 чтоб выводить все',
                'type'        => 'string',
                'default'     => 10,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Максимальное количество отзывов могут быть только числовым параматром'
            ]
        ];
    }

    public function ViewArticlesP()
    {
        if($this->property('maxItems') == 0) return Article::orderBy('id', 'desc')->get();
        else return Article::orderBy('id', 'desc')->take($this->property('maxItems'))->get();
    }
}
