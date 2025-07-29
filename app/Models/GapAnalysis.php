<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GapAnalysis extends Model
{
    use HasFactory;
    
    protected $table = 'gap_analysis';
    
    protected $fillable = [
        'assessment_id',
        'matrix_id',
        'reviewee_name',
        'reviewee_id',
        'reviewer_name',
        'reviewer_id',
        'departemen',
        'fungsi',
        
        // 15 competencies - actual, expected, gap
        'risk_management_actual',
        'risk_management_expected',
        'risk_management_gap',
        
        'business_continuity_actual',
        'business_continuity_expected',
        'business_continuity_gap',
        
        'personnel_management_actual',
        'personnel_management_expected',
        'personnel_management_gap',
        
        'global_tech_awareness_actual',
        'global_tech_awareness_expected',
        'global_tech_awareness_gap',
        
        'physical_security_actual',
        'physical_security_expected',
        'physical_security_gap',
        
        'practical_security_actual',
        'practical_security_expected',
        'practical_security_gap',
        
        'cyber_security_actual',
        'cyber_security_expected',
        'cyber_security_gap',
        
        'investigation_case_mgmt_actual',
        'investigation_case_mgmt_expected',
        'investigation_case_mgmt_gap',
        
        'business_intelligence_actual',
        'business_intelligence_expected',
        'business_intelligence_gap',
        
        'basic_intelligence_actual',
        'basic_intelligence_expected',
        'basic_intelligence_gap',
        
        'mass_conflict_mgmt_actual',
        'mass_conflict_mgmt_expected',
        'mass_conflict_mgmt_gap',
        
        'legal_compliance_actual',
        'legal_compliance_expected',
        'legal_compliance_gap',
        
        'disaster_management_actual',
        'disaster_management_expected',
        'disaster_management_gap',
        
        'sar_actual',
        'sar_expected',
        'sar_gap',
        
        'assessor_actual',
        'assessor_expected',
        'assessor_gap',
        
        // Summary metrics
        'total_gaps_below',
        'total_gaps_above',
        'total_gaps_equal',
        'overall_gap_score'
    ];
    
    protected $casts = [
        'overall_gap_score' => 'decimal:2'
    ];
    
    // Relationships
    public function assessment()
    {
        return $this->belongsTo(FormOtherAstra::class, 'assessment_id');
    }
    
    public function matrix()
    {
        return $this->belongsTo(CompetencyMatrix::class, 'matrix_id');
    }
    
    public function reviewee()
    {
        return $this->belongsTo(Peserta::class, 'reviewee_id');
    }
    
    public function reviewer()
    {
        return $this->belongsTo(Peserta::class, 'reviewer_id');
    }
}
