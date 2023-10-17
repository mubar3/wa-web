<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiWas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_was', function (Blueprint $table) {
            $table->foreignId('tipe_id')->nullable()->after('status')->constrained('tipe_send')->onDelete('cascade');
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
            $table->dropForeign('api_was_tipe_id_foreign');
            $table->dropColumn('tipe_id');
        });
        //
    }
}
