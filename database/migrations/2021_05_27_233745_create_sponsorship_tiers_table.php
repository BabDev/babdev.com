<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorshipTiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'sponsorship_tiers',
            function (Blueprint $table): void {
                $table->id();
                $table->string('node_id')->unique();
                $table->boolean('one_time');
                $table->unsignedInteger('price');
                $table->timestamps();
            },
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorship_tiers');
    }
}
