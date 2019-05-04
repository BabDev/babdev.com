<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoomlaExtensionsTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'joomla_extensions',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug');
                $table->text('logo');
                $table->text('description');
                $table->boolean('supported')->default(true);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('joomla_extensions');
    }
}
