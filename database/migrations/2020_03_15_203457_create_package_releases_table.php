<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'package_releases',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('version');
                $table->string('slug');
                $table->string('maturity');
                $table->text('summary')->nullable();
                $table->text('changelog')->nullable();
                $table->boolean('visible')->default(true);
                $table->dateTime('released_at')->nullable();
                $table->integer('ordering');
                $table->timestamps();

                $table->bigInteger('package_id')->nullable()->unsigned()->index();
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
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
        Schema::dropIfExists('package_releases');
    }
}
