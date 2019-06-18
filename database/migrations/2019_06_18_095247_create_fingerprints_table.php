<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFingerprintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fingerprints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asn_id');
            $table->integer('index');
            $table->integer('alg_ver');
            $table->text('template');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asn_id')
                ->references('id')
                ->on('asn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fingerprints');
    }
}
