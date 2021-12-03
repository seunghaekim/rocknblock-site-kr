<?php namespace Amaryfilo\Blog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateArticleKeyTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('amaryfilo_article_key');
        
        Schema::create('amaryfilo_article_key', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('s_article_id');
            $table->string('article_id');
            $table->primary(['s_article_id', 'article_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amaryfilo_article_key');
    }
}
