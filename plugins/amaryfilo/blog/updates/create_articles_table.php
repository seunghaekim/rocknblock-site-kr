<?php namespace Amaryfilo\Blog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBlogArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('amaryfilo_blog_articles', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slug');
            $table->boolean('is_active')->default(false);
            $table->string('title');
            $table->text('anonce');
            $table->text('text');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amaryfilo_blog_articles');
    }
}
