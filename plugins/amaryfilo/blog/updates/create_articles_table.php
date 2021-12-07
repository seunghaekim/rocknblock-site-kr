<?php namespace Amaryfilo\Blog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBlogArticlesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('amaryfilo_blog_articles');

        Schema::create('amaryfilo_blog_articles', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slug');

            $table->boolean('is_active')->default(false);
            $table->string('title');
            $table->text('anonce');
            $table->text('text');

            $table->string('seo_title');
            $table->string('seo_description');
            $table->string('seo_keywords');
            $table->string('seo_tags');
            $table->string('seo_section');
            $table->boolean('seo_is_author')->default(false);
            $table->string('seo_author');
            $table->string('seo_twitter_description');
            $table->boolean('seo_is_twitter_site')->default(false);
            $table->string('seo_twitter_site');
            $table->boolean('seo_is_person')->default(false);
            $table->string('seo_person');

            $table->timestamp('published_at')->nullable();

            $table->boolean('use_similar_select')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amaryfilo_blog_articles');
    }
}
