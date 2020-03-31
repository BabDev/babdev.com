<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrixAttachmentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'nova_pending_trix_attachments',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('draft_id')->index();
                $table->string('attachment');
                $table->string('disk');
                $table->timestamps();
            }
        );

        Schema::create(
            'nova_trix_attachments',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->morphs('attachable');
                $table->string('attachment');
                $table->string('disk');
                $table->string('url')->index();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_trix_attachments');
        Schema::dropIfExists('nova_pending_trix_attachments');
    }
}
