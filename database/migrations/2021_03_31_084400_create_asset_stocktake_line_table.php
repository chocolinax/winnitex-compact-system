<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetStocktakeLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_stocktake_line', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_stocktake_header_id')->unsigned();
            $table->string('name');
            $table->string('ser_no');
            $table->string('type');
            $table->string('brand');
            $table->enum('status', ['N', 'D'])->default('N');
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
        Schema::dropIfExists('asset_stocktake_line');
    }
}
