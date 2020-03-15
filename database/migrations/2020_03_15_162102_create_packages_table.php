<?php

use BabDev\DocumentationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'packages',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug');
                $table->string('logo')->nullable();
                $table->text('description')->nullable();
                $table->json('topics')->nullable();
                $table->string('documentation_type')->default(DocumentationType::NONE);
                $table->integer('stars')->default(0);
                $table->integer('downloads')->nullable();
                $table->string('language')->nullable();
                $table->boolean('supported')->default(true);
                $table->boolean('visible')->default(true);
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
        Schema::dropIfExists('packages');
    }
}
