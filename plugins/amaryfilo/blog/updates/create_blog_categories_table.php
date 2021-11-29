<?php namespace Amaryfilo\Blog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBlogCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('amaryfilo_blog_categories', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amaryfilo_blog_categories');
    }
}
