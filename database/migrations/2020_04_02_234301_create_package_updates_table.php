<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePackageUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'package_updates',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('package_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('intro');
                $table->longText('content');
                $table->timestamp('published_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->json('data');
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
        Schema::dropIfExists('package_updates');
    }
}
