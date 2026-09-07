<?php

namespace Elyas\Services\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAuditLogsTable extends Migration
{
    public function up()
    {
        Schema::create('elyas_services_audit_logs', function ($table) {
            $table->increments('id');

            $table->integer('backend_user_id')->nullable();
            $table->string('backend_user_name')->nullable();

            $table->string('action');
            $table->string('module');
            $table->integer('record_id')->nullable();

            $table->text('description');
            $table->text('metadata')->nullable();

            $table->timestamps();

            $table->index('action');
            $table->index('module');
            $table->index('backend_user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('elyas_services_audit_logs');
    }
}
