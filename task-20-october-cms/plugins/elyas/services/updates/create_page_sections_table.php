<?php

namespace Elyas\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePageSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('elyas_services_page_sections', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('page_id');

            $table->string('type');
            $table->text('content')->nullable();

            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('page_id')
                ->references('id')
                ->on('elyas_services_pages')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('elyas_services_page_sections');
    }
}
