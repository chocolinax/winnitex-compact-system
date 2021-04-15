<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->string('model_name', 50);
            $table->string('serial_no', 50);
            $table->timestamp('purchased_date');
            $table->string('vendor_name', 50);
            $table->string('alias_name', 20)->nullable();
            $table->string('spec', 255)->nullable();
            $table->string('comment', 255)->nullable();
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
        Schema::dropIfExists('assets');
    }
}
