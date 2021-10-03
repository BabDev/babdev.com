<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'sponsors',
            function (Blueprint $table): void {
                $table->id();
                $table->foreignId('sponsorship_tier_id')->constrained()->onDelete('cascade');
                $table->string('sponsorship_node_id')->unique();
                $table->boolean('is_public');
                $table->string('sponsor_node_id');
                $table->string('sponsor_username');
                $table->string('sponsor_display_name')->nullable();
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
        Schema::dropIfExists('sponsors');
    }
}
