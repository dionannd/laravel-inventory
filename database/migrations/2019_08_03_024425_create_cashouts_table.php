<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashouts', function (Blueprint $table) {
            $table->id();
            $table->string('expense');
            $table->foreignId('finance_id')->constrained('finances')->onDelete('cascade');
            $table->text('desc');
            $table->string('nominal');
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
        Schema::dropIfExists('cashouts');
    }
}
