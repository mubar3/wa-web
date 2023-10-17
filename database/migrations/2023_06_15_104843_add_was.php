<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('was', function (Blueprint $table) {
            $table->string('file')->nullable()->after('pesan');
            $table->enum('jenis',['message','file'])->after('api')->default('message');
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
            $table->dropColumn('file');
            $table->dropColumn('jenis');
        });
        //
    }
}
