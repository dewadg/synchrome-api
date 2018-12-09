<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCalendarEventsTableSetupForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->foreign('calendar_id')
                ->references('id')->on('calendars');
            $table->foreign('attendance_type_id')
                ->references('id')->on('attendance_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropForeign(['attendance_type_id']);
            $table->dropForeign(['calendar_id']);
        });
    }
}
