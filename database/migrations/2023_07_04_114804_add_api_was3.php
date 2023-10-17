<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiWas3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_was', function (Blueprint $table) {
            $table->text('nomor')->after('tipe_id')->nullable();
            $table->enum('training',['y','n'])->after('nomor')->default('n');
            $table->enum('baru',['y','n'])->after('nomor')->default('n');
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
            $table->dropColumn('nomor');
            $table->dropColumn('training');
            $table->dropColumn('baru');
        });
        //
    }
}
