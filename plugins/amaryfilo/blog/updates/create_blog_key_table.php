<?php namespace Amaryfilo\Blog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBlogKeyTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('amaryfilo_blog_key');
        
        Schema::create('amaryfilo_blog_key', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('article_id');
            $table->string('category_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amaryfilo_blog_key');
    }
}
