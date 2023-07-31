<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spend_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tag_id')->constrained('tags')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('spend_id')->constrained('spends')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag_spends');
    }
};
