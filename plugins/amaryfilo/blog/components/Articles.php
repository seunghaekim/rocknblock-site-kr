<?php namespace Amaryfilo\Blog\Components;

use Cms\Classes\ComponentBase;
use Amaryfilo\Blog\Models\Article;
use Amaryfilo\Blog\Models\Category;

use BackendAuth;

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
        $is_user = BackendAuth::getUser();

        if (!$article_one || !$article_one->is_active && !$is_user) {
            $this->controller->setStatusCode(404);
            return $this->controller->run('404');
        } 
        
        $cat = Category::where('id', $article_one->article_category[0]->id)->first();        
        $article_similar = $article_one->use_similar_select ? $article_one->similar_articles->reverse() : $cat->articles_in()->where('is_active', '=', 1)->where('id', '!=', $article_one->id)->take(3)->get()->reverse();
        
        $this->page['article'] = $article_one;
        $this->page['similar_articles'] = $article_similar;
    }

}
