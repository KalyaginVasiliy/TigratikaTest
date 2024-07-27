<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('child_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nomenclature_item_id');
            $table->string('name');
            $table->integer('quantity');
            $table->string('source');
            $table->integer('laser')->nullable();
            $table->integer('welding')->nullable();
            $table->integer('assembly')->nullable();
            $table->integer('electrical')->nullable();
            $table->timestamps();

            $table->foreign('nomenclature_item_id')->references('id')->on('nomenclature_items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('child_items');
    }
};
