<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoomlaExtensionReleasesTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'joomla_extension_releases',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('version');
                $table->string('slug');
                $table->string('maturity');
                $table->text('summary');
                $table->text('changelog');
                $table->boolean('published')->default(true);
                $table->dateTime('published_at');
                $table->integer('ordering');
                $table->timestamps();

                $table->bigInteger('extension_id')->nullable()->unsigned()->index();
                $table->foreign('extension_id')->references('id')->on('joomla_extensions')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('joomla_extension_releases');
    }
}
