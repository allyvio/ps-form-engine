<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveJabatanDepartemenFromPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'departemen']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->string('jabatan', 50)->nullable();
            $table->string('departemen', 50)->nullable();
        });
    }
}
