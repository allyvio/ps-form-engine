<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixGapAnalysisActualColumnsToDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gap_analysis', function (Blueprint $table) {
            // Change all actual columns from integer to decimal(5,2)
            $table->decimal('risk_management_actual', 5, 2)->nullable()->change();
            $table->decimal('business_continuity_actual', 5, 2)->nullable()->change();
            $table->decimal('personnel_management_actual', 5, 2)->nullable()->change();
            $table->decimal('global_tech_awareness_actual', 5, 2)->nullable()->change();
            $table->decimal('physical_security_actual', 5, 2)->nullable()->change();
            $table->decimal('practical_security_actual', 5, 2)->nullable()->change();
            $table->decimal('cyber_security_actual', 5, 2)->nullable()->change();
            $table->decimal('investigation_case_mgmt_actual', 5, 2)->nullable()->change();
            $table->decimal('business_intelligence_actual', 5, 2)->nullable()->change();
            $table->decimal('basic_intelligence_actual', 5, 2)->nullable()->change();
            $table->decimal('mass_conflict_mgmt_actual', 5, 2)->nullable()->change();
            $table->decimal('legal_compliance_actual', 5, 2)->nullable()->change();
            $table->decimal('disaster_management_actual', 5, 2)->nullable()->change();
            $table->decimal('sar_actual', 5, 2)->nullable()->change();
            $table->decimal('assessor_actual', 5, 2)->nullable()->change();
            
            // Also change gap columns to decimal for consistency
            $table->decimal('risk_management_gap', 5, 2)->nullable()->change();
            $table->decimal('business_continuity_gap', 5, 2)->nullable()->change();
            $table->decimal('personnel_management_gap', 5, 2)->nullable()->change();
            $table->decimal('global_tech_awareness_gap', 5, 2)->nullable()->change();
            $table->decimal('physical_security_gap', 5, 2)->nullable()->change();
            $table->decimal('practical_security_gap', 5, 2)->nullable()->change();
            $table->decimal('cyber_security_gap', 5, 2)->nullable()->change();
            $table->decimal('investigation_case_mgmt_gap', 5, 2)->nullable()->change();
            $table->decimal('business_intelligence_gap', 5, 2)->nullable()->change();
            $table->decimal('basic_intelligence_gap', 5, 2)->nullable()->change();
            $table->decimal('mass_conflict_mgmt_gap', 5, 2)->nullable()->change();
            $table->decimal('legal_compliance_gap', 5, 2)->nullable()->change();
            $table->decimal('disaster_management_gap', 5, 2)->nullable()->change();
            $table->decimal('sar_gap', 5, 2)->nullable()->change();
            $table->decimal('assessor_gap', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gap_analysis', function (Blueprint $table) {
            // Revert all actual columns back to integer
            $table->integer('risk_management_actual')->nullable()->change();
            $table->integer('business_continuity_actual')->nullable()->change();
            $table->integer('personnel_management_actual')->nullable()->change();
            $table->integer('global_tech_awareness_actual')->nullable()->change();
            $table->integer('physical_security_actual')->nullable()->change();
            $table->integer('practical_security_actual')->nullable()->change();
            $table->integer('cyber_security_actual')->nullable()->change();
            $table->integer('investigation_case_mgmt_actual')->nullable()->change();
            $table->integer('business_intelligence_actual')->nullable()->change();
            $table->integer('basic_intelligence_actual')->nullable()->change();
            $table->integer('mass_conflict_mgmt_actual')->nullable()->change();
            $table->integer('legal_compliance_actual')->nullable()->change();
            $table->integer('disaster_management_actual')->nullable()->change();
            $table->integer('sar_actual')->nullable()->change();
            $table->integer('assessor_actual')->nullable()->change();
            
            // Revert gap columns back to integer
            $table->integer('risk_management_gap')->nullable()->change();
            $table->integer('business_continuity_gap')->nullable()->change();
            $table->integer('personnel_management_gap')->nullable()->change();
            $table->integer('global_tech_awareness_gap')->nullable()->change();
            $table->integer('physical_security_gap')->nullable()->change();
            $table->integer('practical_security_gap')->nullable()->change();
            $table->integer('cyber_security_gap')->nullable()->change();
            $table->integer('investigation_case_mgmt_gap')->nullable()->change();
            $table->integer('business_intelligence_gap')->nullable()->change();
            $table->integer('basic_intelligence_gap')->nullable()->change();
            $table->integer('mass_conflict_mgmt_gap')->nullable()->change();
            $table->integer('legal_compliance_gap')->nullable()->change();
            $table->integer('disaster_management_gap')->nullable()->change();
            $table->integer('sar_gap')->nullable()->change();
            $table->integer('assessor_gap')->nullable()->change();
        });
    }
}
