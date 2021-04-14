<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('wtxuser_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('asset')->unsigned();
            $table->timestamp('stocktake_at');
            $table->enum('status', ['N', 'D'])->default('N');
            $table->string('create_user_id');
            $table->integer('last_update_user_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record_lists');
    }
}
