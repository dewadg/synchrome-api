<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEchelonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('echelons', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('echelon_type_id');
            $table->string('supervisor_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('echelon_type_id')
                ->references('id')
                ->on('echelon_types');

            $table->foreign('supervisor_id')
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
        Schema::dropIfExists('echelons');
    }
}
