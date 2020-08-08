<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLossesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('losses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice')->constrained('purchases')->onDelete('cascade');
            $table->string('product_id');
            $table->integer('qty');
            $table->integer('price');
            $table->dateTime('date');
            $table->string('total');
            $table->text('desc')->nullable();
            $table->enum('status', ['checking','checked'])->default('checking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('losses');
    }
}
