<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('head_echelon_id')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->foreign('head_echelon_id')
                ->references('id')
                ->on('echelons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
}
