<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asn', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('agency_id');
            $table->string('rank_id');
            $table->string('echelon_id');
            $table->unsignedInteger('tpp_id');
            $table->unsignedInteger('workshift_id');
            $table->unsignedInteger('calendar_id');
            $table->string('pin')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('agency_id')->references('id')->on('agencies');
            $table->foreign('rank_id')->references('id')->on('ranks');
            $table->foreign('echelon_id')->references('id')->on('echelons');
            $table->foreign('tpp_id')->references('id')->on('tpp');
            $table->foreign('workshift_id')->references('id')->on('workshifts');
            $table->foreign('calendar_id')->references('id')->on('calendars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asn');
    }
}
