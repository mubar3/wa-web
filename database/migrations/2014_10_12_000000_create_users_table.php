<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telpon');
            $table->string('foto');
            $table->string('password');
            $table->enum('status',['y','n'])->default('y');
            $table->timestamps();
        });

        DB::table('users')->insert(
        array(
            'id' => 1,
            'username' => 'Admin',
            'nama' => 'Admin',
            'email' => 'Admin@admin.com',
            'password' => '$2y$10$RaKn2MpyUsUeqhp.uzPVR.jzLMf2XS9bpOzCIrtD1gspWUal.BwwK',
            'foto' => 'user.png',
            'status' => 'y',
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
        Schema::dropIfExists('users');
    }
}
