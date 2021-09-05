<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('name', 255);
            $table->bigInteger('career_id');
            $table->string('email', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('message')->nullable();
            $table->string('cv_file', 255);
            $table->tinyInteger('status')->default(0)->comment('0: New, 1: Approve CV, 2: Rejected');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->primary(array('id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
