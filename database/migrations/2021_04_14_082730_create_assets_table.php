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
            $table->string('model_name');
            $table->string('serial_no');
            $table->timestamp('purchased_at');
            $table->string('vendor_name');
            $table->string('alias_name')->nullable();
            $table->string('spec')->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
