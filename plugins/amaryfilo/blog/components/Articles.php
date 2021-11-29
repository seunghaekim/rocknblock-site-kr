<?php namespace Amaryfilo\Blog\Components;

use Cms\Classes\ComponentBase;
use Amaryfilo\Blog\Models\Article;
use Amaryfilo\Blog\Models\Video;

class Articles extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Статья',
            'description' => 'Выводит 1 статью используется slug'
        ];
    }

    public function defineProperties()
    {
        return [
        'slug' => [
                'title'       => 'Slug',
                'description' => 'Введите переменную',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
        ];
    }

    public function onRun()
    {
        $slug = $this->property('slug');

        $article_one = Article::where('slug', $slug)->first();

        if (!$article_one) {
            $this->controller->setStatusCode(404);
            return $this->controller->run('404');
        } $this->page['article'] = $article_one;
    }

}
