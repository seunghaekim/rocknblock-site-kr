<?php namespace amaryfilo\Feedback\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSendsTable extends Migration
{
    public function up()
    {
        Schema::create('amaryfilo_feedback_sends', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amaryfilo_feedback_sends');
    }
}
