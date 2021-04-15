<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWtxusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wtxusers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 50);
            $table->integer('department_id')->unsigned();
            $table->integer('ext');
            $table->enum('status', ['N', 'D'])->default('N');
            $table->string('create_user_login_id');
            $table->string('last_modified_user_login_id');
            $table->timestamp('create_date_time');
            $table->timestamp('last_modified_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wtxusers');
    }
}
