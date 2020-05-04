<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('design_performer_id');
            $table->unsignedBigInteger('design_type_id');
            $table->string('title');
            $table->text('description');
            $table->json('attachment');
            $table->string('broadcast_identifier');
            $table->integer('cost');

            $table->timestampsTz();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('design_performer_id')->references('id')->on('design_performer');
            $table->foreign('design_type_id')->references('id')->on('design_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
