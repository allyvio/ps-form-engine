<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormOtherAstra extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'form_id',
        'reviewer_name',
        'reviewer_id',
        'reviewee_name',
        'reviewee_id',
        'submission_date',
        'submission_id',
        'departemen',
        'fungsi',
        'peran',
        'risk_management_rating',
        'risk_management_narrative',
        'business_continuity_rating',
        'business_continuity_narrative',
        'personnel_management_rating',
        'personnel_management_narrative',
        'global_tech_awareness_rating',
        'global_tech_awareness_narrative',
        'physical_security_rating',
        'physical_security_narrative',
        'practical_security_rating',
        'practical_security_narrative',
        'cyber_security_rating',
        'cyber_security_narrative',
        'investigation_case_mgmt_rating',
        'investigation_case_mgmt_narrative',
        'business_intelligence_rating',
        'business_intelligence_narrative',
        'basic_intelligence_rating',
        'basic_intelligence_narrative',
        'mass_conflict_mgmt_rating',
        'mass_conflict_mgmt_narrative',
        'legal_compliance_rating',
        'legal_compliance_narrative',
        'disaster_management_rating',
        'disaster_management_narrative',
        'sar_rating',
        'sar_narrative',
        'assessor_rating',
        'assessor_narrative'
    ];
    
    public function reviewer()
    {
        return $this->belongsTo(Peserta::class, 'reviewer_id');
    }
    
    public function reviewee()
    {
        return $this->belongsTo(Peserta::class, 'reviewee_id');
    }
    
    // Cast dates
    protected $dates = [
        'submission_date'
    ];
}
