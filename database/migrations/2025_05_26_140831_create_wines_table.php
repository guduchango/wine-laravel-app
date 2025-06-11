<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wines', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('variety');
            $table->integer('vintage');
            $table->float('alcohol');
            $table->float('price');
            $table->string('color');
            $table->string('aroma');
            $table->string('sweetness');
            $table->string('acidity');
            $table->string('tannin');
            $table->string('body');
            $table->string('persistence');
            $table->string('score');
            $table->date('tasted_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wines');
    }
};
