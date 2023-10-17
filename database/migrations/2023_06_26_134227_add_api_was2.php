<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiWas2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_was', function (Blueprint $table) {
            $table->enum('cronjob',['y','n'])->after('tipe_id')->default('y');
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_was', function (Blueprint $table) {
            $table->dropColumn('cronjob');
        });
        //
    }
}
