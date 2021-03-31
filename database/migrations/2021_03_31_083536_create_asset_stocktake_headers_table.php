<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetStocktakeHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_stocktake_headers', function (Blueprint $table) {
            $table->id();
            $table->string('team');
            $table->string('name');
            $table->string('ext');
            $table->string('location');
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
        Schema::dropIfExists('asset_stocktake_headers');
    }
}
