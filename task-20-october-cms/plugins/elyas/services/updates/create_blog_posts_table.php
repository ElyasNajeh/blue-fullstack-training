<?php

namespace Elyas\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBlogPostsTable Migration
 *
 * @link https://docs.octobercms.com/4.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('elyas_services_blog_posts', function ($table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('excerpt');
            $table->text('content');

            $table->unsignedInteger('blog_category_id');

            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->foreign('blog_category_id')
                ->references('id')
                ->on('elyas_services_blog_categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('elyas_services_blog_posts');
    }
};
