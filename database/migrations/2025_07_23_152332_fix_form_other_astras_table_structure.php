<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFormOtherAstrasTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_other_astras', function (Blueprint $table) {
            // Drop old columns (use correct column names)
            $table->dropColumn([
                'name', 'name_id', 'rater_for', 'rater_for_id', 
                'date_created'
            ]);
            
            // Add new columns with clear naming
            $table->string('reviewer_name', 128)->after('form_id'); // Yang menilai
            $table->integer('reviewer_id')->nullable()->after('reviewer_name');
            $table->string('reviewee_name', 128)->after('reviewer_id'); // Yang dinilai  
            $table->integer('reviewee_id')->nullable()->after('reviewee_name');
            $table->date('submission_date')->nullable()->after('reviewee_id');
            $table->string('submission_id', 50)->nullable()->after('submission_date');
            
            // Rename question columns to competency names
            $table->renameColumn('question_1_value', 'risk_management_rating');
            $table->renameColumn('question_1_text', 'risk_management_narrative');
            $table->renameColumn('question_2_value', 'business_continuity_rating');
            $table->renameColumn('question_2_text', 'business_continuity_narrative');
            $table->renameColumn('question_3_value', 'personnel_management_rating');
            $table->renameColumn('question_3_text', 'personnel_management_narrative');
            $table->renameColumn('question_4_value', 'global_tech_awareness_rating');
            $table->renameColumn('question_4_text', 'global_tech_awareness_narrative');
            $table->renameColumn('question_5_value', 'physical_security_rating');
            $table->renameColumn('question_5_text', 'physical_security_narrative');
            $table->renameColumn('question_6_value', 'practical_security_rating');
            $table->renameColumn('question_6_text', 'practical_security_narrative');
            $table->renameColumn('question_7_value', 'cyber_security_rating');
            $table->renameColumn('question_7_text', 'cyber_security_narrative');
            $table->renameColumn('question_8_value', 'investigation_case_mgmt_rating');
            $table->renameColumn('question_8_text', 'investigation_case_mgmt_narrative');
            $table->renameColumn('question_9_value', 'business_intelligence_rating');
            $table->renameColumn('question_9_text', 'business_intelligence_narrative');
            $table->renameColumn('question_10_value', 'basic_intelligence_rating');
            $table->renameColumn('question_10_text', 'basic_intelligence_narrative');
            $table->renameColumn('question_11_value', 'mass_conflict_mgmt_rating');
            $table->renameColumn('question_11_text', 'mass_conflict_mgmt_narrative');
            $table->renameColumn('question_12_value', 'legal_compliance_rating');
            $table->renameColumn('question_12_text', 'legal_compliance_narrative');
            $table->renameColumn('question_13_value', 'disaster_management_rating');
            $table->renameColumn('question_13_text', 'disaster_management_narrative');
            $table->renameColumn('question_14_value', 'sar_rating');
            $table->renameColumn('question_14_text', 'sar_narrative');
            $table->renameColumn('question_15_value', 'assessor_rating');
            $table->renameColumn('question_15_text', 'assessor_narrative');
            
            // Add foreign key constraints
            $table->foreign('reviewer_id')->references('id')->on('peserta')->onDelete('set null');
            $table->foreign('reviewee_id')->references('id')->on('peserta')->onDelete('set null');
            
            // Add indexes for performance
            $table->index('reviewer_id');
            $table->index('reviewee_id');
            $table->index('submission_date');
            $table->index('submission_id');
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
            // Drop foreign keys and indexes
            $table->dropForeign('form_other_astras_reviewer_id_foreign');
            $table->dropForeign('form_other_astras_reviewee_id_foreign');
            $table->dropIndex(['reviewer_id']);
            $table->dropIndex(['reviewee_id']);
            $table->dropIndex(['submission_date']);
            $table->dropIndex(['submission_id']);
            
            // Rename competency columns back to question format
            $table->renameColumn('risk_management_rating', 'question_1_value');
            $table->renameColumn('risk_management_narrative', 'question_1_text');
            $table->renameColumn('business_continuity_rating', 'question_2_value');
            $table->renameColumn('business_continuity_narrative', 'question_2_text');
            $table->renameColumn('personnel_management_rating', 'question_3_value');
            $table->renameColumn('personnel_management_narrative', 'question_3_text');
            $table->renameColumn('global_tech_awareness_rating', 'question_4_value');
            $table->renameColumn('global_tech_awareness_narrative', 'question_4_text');
            $table->renameColumn('physical_security_rating', 'question_5_value');
            $table->renameColumn('physical_security_narrative', 'question_5_text');
            $table->renameColumn('practical_security_rating', 'question_6_value');
            $table->renameColumn('practical_security_narrative', 'question_6_text');
            $table->renameColumn('cyber_security_rating', 'question_7_value');
            $table->renameColumn('cyber_security_narrative', 'question_7_text');
            $table->renameColumn('investigation_case_mgmt_rating', 'question_8_value');
            $table->renameColumn('investigation_case_mgmt_narrative', 'question_8_text');
            $table->renameColumn('business_intelligence_rating', 'question_9_value');
            $table->renameColumn('business_intelligence_narrative', 'question_9_text');
            $table->renameColumn('basic_intelligence_rating', 'question_10_value');
            $table->renameColumn('basic_intelligence_narrative', 'question_10_text');
            $table->renameColumn('mass_conflict_mgmt_rating', 'question_11_value');
            $table->renameColumn('mass_conflict_mgmt_narrative', 'question_11_text');
            $table->renameColumn('legal_compliance_rating', 'question_12_value');
            $table->renameColumn('legal_compliance_narrative', 'question_12_text');
            $table->renameColumn('disaster_management_rating', 'question_13_value');
            $table->renameColumn('disaster_management_narrative', 'question_13_text');
            $table->renameColumn('sar_rating', 'question_14_value');
            $table->renameColumn('sar_narrative', 'question_14_text');
            $table->renameColumn('assessor_rating', 'question_15_value');
            $table->renameColumn('assessor_narrative', 'question_15_text');
            
            // Drop new columns
            $table->dropColumn([
                'reviewer_name', 'reviewer_id', 'reviewee_name', 'reviewee_id',
                'submission_date', 'submission_id'
            ]);
            
            // Add old columns back (use correct column names)
            $table->string('name', 128)->after('form_id');
            $table->integer('name_id')->nullable()->after('name');
            $table->string('rater_for', 128)->after('name_id');
            $table->integer('rater_for_id')->nullable()->after('rater_for');
            $table->string('date_created', 50)->after('question_15_text');
        });
    }
}
