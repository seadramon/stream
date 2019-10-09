<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvradiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvradios', function (Blueprint $table) {
            $table->increments('id');

            $table->string('key')->unique();
            $table->string('name');
            $table->text('stream');
            $table->text('image');
            $table->string('bgcolor')->nullable();
            $table->integer('position');
            $table->enum('channel', ['tv', 'radio']);
            $table->enum('status', [1, 0]);

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
        Schema::dropIfExists('tvradios');
    }
}
