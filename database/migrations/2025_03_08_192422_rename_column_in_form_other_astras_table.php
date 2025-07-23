<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInFormOtherAstrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_other_astras', function (Blueprint $table) {
            $table->renameColumn('rater_name', 'rater_for');
            $table->renameColumn('rater_id', 'rater_for_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_other_astras', function (Blueprint $table) {
            //
        });
    }
}
