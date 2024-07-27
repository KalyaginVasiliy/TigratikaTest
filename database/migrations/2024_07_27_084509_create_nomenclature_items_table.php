<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nomenclature_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->string('source');
            $table->integer('laser')->nullable();
            $table->integer('welding')->nullable();
            $table->integer('assembly')->nullable();
            $table->integer('electrical')->nullable();
            $table->integer('position');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nomenclature_items');
    }
};
