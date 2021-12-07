<?php namespace Amaryfilo\Blog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use System\Classes\PluginManager;


class AddPublishedAtColumn extends Migration
{

    const TABLE = 'amaryfilo_blog_articles';

    /**
     * Execute migrations
     */
    public function up()
    {
        if (PluginManager::instance()->hasPlugin('Amaryfilo.Blog')) {
            $this->createFields();
        }
    }

    /**
     * Rollback migrations
     */
    public function down()
    {
        if (PluginManager::instance()->hasPlugin('RainLab.Blog')) {
            $this->dropFields();
        }
    }

    /**
     * Remove new fields
     */
    private function dropFields()
    {
        $this->dropColumn('published_at');
    }

    /**
     * Create new fields
     */
    private function createFields()
    {

        if (!Schema::hasColumn(self::TABLE,'published_at')) {
            Schema::table(self::TABLE, function ($table) {
                $table->timestamp('published_at')->nullable();
            });
        }
    }

    /**
     * @param string $column
     */
    private function dropColumn(string $column)
    {
        if (Schema::hasColumn(self::TABLE, $column)) {
            Schema::table(self::TABLE, function ($table) use ($column) {
                $table->dropColumn($column);
            });
        }
    }
}