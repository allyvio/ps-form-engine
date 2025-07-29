<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyMatrix extends Model
{
    use HasFactory;
    
    protected $table = 'competency_matrix';
    
    protected $fillable = [
        'departemen',
        'fungsi',
        'risk_management_expected',
        'business_continuity_expected',
        'personnel_management_expected',
        'global_tech_awareness_expected',
        'physical_security_expected',
        'practical_security_expected',
        'cyber_security_expected',
        'investigation_case_mgmt_expected',
        'business_intelligence_expected',
        'basic_intelligence_expected',
        'mass_conflict_mgmt_expected',
        'legal_compliance_expected',
        'disaster_management_expected',
        'sar_expected',
        'assessor_expected'
    ];
    
    /**
     * Get expected level for a specific competency
     */
    public function getExpectedLevel($competency)
    {
        $field = $competency . '_expected';
        return $this->$field;
    }
    
    /**
     * Get all expected levels as array
     */
    public function getAllExpectedLevels()
    {
        return [
            'risk_management' => $this->risk_management_expected,
            'business_continuity' => $this->business_continuity_expected,
            'personnel_management' => $this->personnel_management_expected,
            'global_tech_awareness' => $this->global_tech_awareness_expected,
            'physical_security' => $this->physical_security_expected,
            'practical_security' => $this->practical_security_expected,
            'cyber_security' => $this->cyber_security_expected,
            'investigation_case_mgmt' => $this->investigation_case_mgmt_expected,
            'business_intelligence' => $this->business_intelligence_expected,
            'basic_intelligence' => $this->basic_intelligence_expected,
            'mass_conflict_mgmt' => $this->mass_conflict_mgmt_expected,
            'legal_compliance' => $this->legal_compliance_expected,
            'disaster_management' => $this->disaster_management_expected,
            'sar' => $this->sar_expected,
            'assessor' => $this->assessor_expected
        ];
    }
    
    /**
     * Find matrix by department and function (case insensitive)
     */
    public static function findByDepartmentFunction($departemen, $fungsi)
    {
        // First try exact match
        $exactMatch = static::where('departemen', $departemen)
                           ->where('fungsi', $fungsi)
                           ->first();
        
        if ($exactMatch) {
            return $exactMatch;
        }
        
        // If no exact match, try case insensitive match for both department and function
        return static::whereRaw('LOWER(departemen) = LOWER(?)', [$departemen])
                    ->whereRaw('LOWER(fungsi) = LOWER(?)', [$fungsi])
                    ->first();
    }
}
