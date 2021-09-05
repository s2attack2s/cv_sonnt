<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('job_type_id');
            $table->bigInteger('language_id')->default(1);
            $table->string('image', 255);
            $table->string('short_desc', 255);
            $table->bigInteger('location_id');
            $table->dateTime('start_at');
            $table->dateTime('finish_at')->nullable();
            $table->integer('quantity')->default(1);
            $table->smallInteger('status')->default(0);
            $table->string('salary', 255)->nullable();
            $table->text('detail')->nullable();
            $table->text('skill_required')->nullable();
            $table->text('priority')->nullable();
            $table->text('benefit')->nullable();
            $table->text('contact')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('careers');
    }
}
