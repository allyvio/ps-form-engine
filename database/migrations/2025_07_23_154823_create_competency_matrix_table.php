<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetencyMatrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competency_matrix', function (Blueprint $table) {
            $table->id();
            $table->string('departemen', 100);
            $table->string('fungsi', 100);
            
            // 15 Core Competencies - Expected Levels (1-4 or null for N/A)
            $table->integer('risk_management_expected')->nullable();
            $table->integer('business_continuity_expected')->nullable();
            $table->integer('personnel_management_expected')->nullable();
            $table->integer('global_tech_awareness_expected')->nullable();
            $table->integer('physical_security_expected')->nullable();
            $table->integer('practical_security_expected')->nullable();
            $table->integer('cyber_security_expected')->nullable();
            $table->integer('investigation_case_mgmt_expected')->nullable();
            $table->integer('business_intelligence_expected')->nullable();
            $table->integer('basic_intelligence_expected')->nullable();
            $table->integer('mass_conflict_mgmt_expected')->nullable();
            $table->integer('legal_compliance_expected')->nullable();
            $table->integer('disaster_management_expected')->nullable();
            $table->integer('sar_expected')->nullable();
            $table->integer('assessor_expected')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('departemen');
            $table->index('fungsi');
            $table->index(['departemen', 'fungsi']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competency_matrix');
    }
}
