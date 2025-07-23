<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormOtherAstrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_other_astras', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id');
            $table->string('name', 128);
            $table->integer('name_id')->nullable();
            $table->string('rater_name', 128);
            $table->integer('rater_id')->nullable();
            $table->string('departemen',128);
            $table->string('fungsi',128);
            $table->string('peran',128);
            $table->integer('question_1_value')->nullable();
            $table->longText('question_1_text')->nullable();
            $table->integer('question_2_value')->nullable();
            $table->longText('question_2_text')->nullable();
            $table->integer('question_3_value')->nullable();
            $table->longText('question_3_text')->nullable();
            $table->integer('question_4_value')->nullable();
            $table->longText('question_4_text')->nullable();
            $table->integer('question_5_value')->nullable();
            $table->longText('question_5_text')->nullable();
            $table->integer('question_6_value')->nullable();
            $table->longText('question_6_text')->nullable();
            $table->integer('question_7_value')->nullable();
            $table->longText('question_7_text')->nullable();
            $table->integer('question_8_value')->nullable();
            $table->longText('question_8_text')->nullable();
            $table->integer('question_9_value')->nullable();
            $table->longText('question_9_text')->nullable();
            $table->integer('question_10_value')->nullable();
            $table->longText('question_10_text')->nullable();
            $table->integer('question_11_value')->nullable();
            $table->longText('question_11_text')->nullable();
            $table->integer('question_12_value')->nullable();
            $table->longText('question_12_text')->nullable();
            $table->integer('question_13_value')->nullable();
            $table->longText('question_13_text')->nullable();
            $table->integer('question_14_value')->nullable();
            $table->longText('question_14_text')->nullable();
            $table->integer('question_15_value')->nullable();
            $table->longText('question_15_text')->nullable();
            $table->string('date_created',50);
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
        Schema::dropIfExists('form_other_astras');
    }
}
