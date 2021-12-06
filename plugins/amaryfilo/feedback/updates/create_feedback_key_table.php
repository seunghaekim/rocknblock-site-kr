<?php namespace amaryfilo\Feedback\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateFeedbackKeyTable extends Migration
{
    public function up()
    {
        Schema::create('amaryfilo_feedback_key', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('feedback_id');
            $table->string('input_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amaryfilo_feedback_key');
    }
}
