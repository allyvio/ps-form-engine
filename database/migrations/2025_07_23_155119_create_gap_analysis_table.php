<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGapAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gap_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('form_other_astras')->onDelete('cascade');
            $table->foreignId('matrix_id')->nullable()->constrained('competency_matrix')->onDelete('set null');
            
            // Basic info
            $table->string('reviewee_name');
            $table->integer('reviewee_id')->nullable();
            $table->string('reviewer_name');
            $table->integer('reviewer_id')->nullable();
            $table->string('departemen');
            $table->string('fungsi');
            
            // Gap analysis for 15 competencies (actual - expected)
            $table->integer('risk_management_actual')->nullable();
            $table->integer('risk_management_expected')->nullable();
            $table->integer('risk_management_gap')->nullable(); // negative = below expectation
            
            $table->integer('business_continuity_actual')->nullable();
            $table->integer('business_continuity_expected')->nullable();
            $table->integer('business_continuity_gap')->nullable();
            
            $table->integer('personnel_management_actual')->nullable();
            $table->integer('personnel_management_expected')->nullable();
            $table->integer('personnel_management_gap')->nullable();
            
            $table->integer('global_tech_awareness_actual')->nullable();
            $table->integer('global_tech_awareness_expected')->nullable();
            $table->integer('global_tech_awareness_gap')->nullable();
            
            $table->integer('physical_security_actual')->nullable();
            $table->integer('physical_security_expected')->nullable();
            $table->integer('physical_security_gap')->nullable();
            
            $table->integer('practical_security_actual')->nullable();
            $table->integer('practical_security_expected')->nullable();
            $table->integer('practical_security_gap')->nullable();
            
            $table->integer('cyber_security_actual')->nullable();
            $table->integer('cyber_security_expected')->nullable();
            $table->integer('cyber_security_gap')->nullable();
            
            $table->integer('investigation_case_mgmt_actual')->nullable();
            $table->integer('investigation_case_mgmt_expected')->nullable();
            $table->integer('investigation_case_mgmt_gap')->nullable();
            
            $table->integer('business_intelligence_actual')->nullable();
            $table->integer('business_intelligence_expected')->nullable();
            $table->integer('business_intelligence_gap')->nullable();
            
            $table->integer('basic_intelligence_actual')->nullable();
            $table->integer('basic_intelligence_expected')->nullable();
            $table->integer('basic_intelligence_gap')->nullable();
            
            $table->integer('mass_conflict_mgmt_actual')->nullable();
            $table->integer('mass_conflict_mgmt_expected')->nullable();
            $table->integer('mass_conflict_mgmt_gap')->nullable();
            
            $table->integer('legal_compliance_actual')->nullable();
            $table->integer('legal_compliance_expected')->nullable();
            $table->integer('legal_compliance_gap')->nullable();
            
            $table->integer('disaster_management_actual')->nullable();
            $table->integer('disaster_management_expected')->nullable();
            $table->integer('disaster_management_gap')->nullable();
            
            $table->integer('sar_actual')->nullable();
            $table->integer('sar_expected')->nullable();
            $table->integer('sar_gap')->nullable();
            
            $table->integer('assessor_actual')->nullable();
            $table->integer('assessor_expected')->nullable();
            $table->integer('assessor_gap')->nullable();
            
            // Summary metrics
            $table->integer('total_gaps_below')->default(0); // Count of negative gaps
            $table->integer('total_gaps_above')->default(0); // Count of positive gaps
            $table->integer('total_gaps_equal')->default(0); // Count of zero gaps
            $table->decimal('overall_gap_score', 5, 2)->nullable(); // Average gap score
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('assessment_id');
            $table->index('reviewee_id');
            $table->index('reviewer_id');
            $table->index(['departemen', 'fungsi']);
            $table->index('overall_gap_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gap_analysis');
    }
}
