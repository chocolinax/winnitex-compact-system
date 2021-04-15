<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->enum('status', ['N', 'D'])->default('N');
            $table->integer('create_user_login_id')->unsigned();
            $table->integer('last_modified_user_login_id')->unsigned();
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
        Schema::dropIfExists('types');
    }
}
