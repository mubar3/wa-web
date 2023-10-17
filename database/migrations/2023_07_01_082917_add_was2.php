<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWas2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('was', function (Blueprint $table) {
            $table->string('id_wa')->nullable()->after('id');
            $table->enum('read',['y','n'])->after('status_kirim')->default('n');
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
        Schema::table('was', function (Blueprint $table) {
            $table->dropColumn('id_wa');
            $table->dropColumn('read');
        });
        //
    }
}
