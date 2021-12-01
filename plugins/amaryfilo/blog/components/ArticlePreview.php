<?php namespace Amaryfilo\Blog\Components;

use Cms\Classes\ComponentBase;
use Amaryfilo\Blog\Models\Article;
use Amaryfilo\Blog\Models\Category;

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
    
    public function ViewCategories() {
        return Category::orderBy('id', 'desc')->where('show', true)->where('show_in_modules', true)->get();
    }

    public function ViewArticles() {
        return $this->property('maxItems') == 0 ? Article::orderBy('id', 'desc')->where('is_active', true)->get() : Article::orderBy('id', 'desc')->where('is_active', true)->take($this->property('maxItems'))->get();
    }
}
