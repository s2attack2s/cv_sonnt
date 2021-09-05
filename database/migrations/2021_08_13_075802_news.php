<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class News extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->string('code', 10);
            $table->string('title', 255);
            $table->string('thumbnail', 255);
            $table->text('content')->nullable();
            $table->string('author', 255)->nullable();
            $table->date('published_date')->nullable();
            $table->string('website', 255)->nullable();
            $table->tinyInteger('is_published')->default(0);
            $table->integer('language_id')->default(1)->comment('1: English, 2: Japanese, 3: Vietnam');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('news');
    }
}
