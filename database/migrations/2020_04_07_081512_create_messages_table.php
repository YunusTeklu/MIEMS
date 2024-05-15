<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from');
            $table->string('to');
            $table->string('patient_name');
            $table->integer('patient_age');
            $table->string('patient_gender');
            $table->string('medical_image_type');
            $table->longText('note')->nullable();
            $table->string('state');
            $table->string('algorithm');
            $table->longText('encrypted_image');
            $table->float('encryption_time');
            $table->float('image_size');
            $table->string('image_name');
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
        Schema::dropIfExists('messages');
    }
}
