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
        Schema::create('hall_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_id')->unsigned();
            $table->foreign('hall_id')->references('id')->on('halls')->onDelete('cascade');
            $table->integer('row');
            $table->integer('seat');
            $table->string('status')->default('standart');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hall_configs');
    }
};
