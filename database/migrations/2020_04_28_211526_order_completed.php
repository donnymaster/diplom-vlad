<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderCompleted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_completed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('design_performer');
            $table->float('rating')->nullable();
            $table->json('attachment');

            $table->timestampsTz();

            $table->foreign('order_id')->references('id')->on('order');
            $table->foreign('design_performer')->references('id')->on('design_performer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_completed');
    }
}
