<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class CreateUmumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umums', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('npsn');
            $table->string('email')->nullable();
            $table->string('telpon')->nullable();
            $table->string('alamat');
            $table->string('logo');
            $table->string('favicon');
            $table->timestamps();
        });DB::table('umums')->insert(
        array(
            'nama' => 'Sent WA',
            'npsn' => '86727812',
            'email' => 'Admin@admin.com',
            'logo' => 'logo.jpg',
            'favicon' => 'icon.jpg',
            'created_at' => Carbon::now()
        )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umums');
    }
}
