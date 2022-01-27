<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
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

    public function down(): void
    {
        Schema::dropIfExists('sponsorship_tiers');
    }
};
