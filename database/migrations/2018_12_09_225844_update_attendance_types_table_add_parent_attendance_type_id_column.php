<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAttendanceTypesTableAddParentAttendanceTypeIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_types', function (Blueprint $table) {
            $table->unsignedInteger('parent_attendance_type_id')->nullable();
            $table->foreign('parent_attendance_type_id')
                ->references('id')
                ->on('attendance_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_types', function (Blueprint $table) {
            $table->dropForeign(['parent_attendance_type_id']);
            $table->dropColumn('parent_attendance_type_id');
        });
    }
}
