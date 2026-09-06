<?php

namespace Elyas\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDocumentCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('elyas_services_document_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('status')->default('active');

            $table->integer('display_order')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('elyas_services_document_categories');
    }
}
