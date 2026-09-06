<?php

namespace Elyas\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('elyas_services_documents', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('description');

            $table->unsignedInteger('document_category_id');

            $table->string('status')->default('draft');

            $table->timestamp('published_at')->nullable();

            $table->unsignedInteger('download_count')->default(0);

            $table->timestamps();

            $table->foreign('document_category_id')
                ->references('id')
                ->on('elyas_services_document_categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('elyas_services_documents');
    }
}
