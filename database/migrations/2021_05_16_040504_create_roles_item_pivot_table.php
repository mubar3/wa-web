<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesItemPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_item_pivot', function (Blueprint $table) {
            $table->foreignId('roles_id')->constrained()->onDelete('cascade');
            $table->foreignId('roles_item_id')->constrained()->onDelete('cascade');
            $table->integer('create');
            $table->integer('read');
            $table->integer('update');
            $table->integer('delete');
            $table->integer('print');
            $table->timestamps();

            $table->primary(['roles_id','roles_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_item_pivot');
    }
}
