# Manual Template Fix Required - template_2.docx

## Current Problem
Template `template_2.docx` memiliki:
- ✅ Dynamic variables: `${nama_karyawan}`, `${departemen}`, `${fungsi}`
- ❌ **Static table data** yang tidak berubah saat download

## What Needs to be Done

### Current Table (Static Data):
```
Kompetensi          | Atasan (60%)  | Diri (20%)  | Rekan Kerja (20%)  | Actual Level | Required Level | Gap
Risk Management     | 1             | 3           | 1.7                | 1            | 3              | -2
Business Continuity | 2             | 2           | 2                  | 2            | 3              | -1
... (etc - all static)
```

### Required Template Structure (Dynamic Variables):
```
Kompetensi                    | Atasan (35%)                    | Diri (15%)                  | Rekan Kerja (50%)                    | Actual Level                    | Required Level                    | Gap
Risk Management               | ${risk_management_atasan}       | ${risk_management_self}     | ${risk_management_rekan_kerja}       | ${risk_management_actual}       | ${risk_management_required}       | ${risk_management_gap}
Business Continuity           | ${business_continuity_atasan}   | ${business_continuity_self} | ${business_continuity_rekan_kerja}   | ${business_continuity_actual}   | ${business_continuity_required}   | ${business_continuity_gap}
Personnel Management          | ${personnel_management_atasan}  | ${personnel_management_self}| ${personnel_management_rekan_kerja}  | ${personnel_management_actual}  | ${personnel_management_required}  | ${personnel_management_gap}
Global & Technological Awareness | ${global_tech_awareness_atasan} | ${global_tech_awareness_self} | ${global_tech_awareness_rekan_kerja} | ${global_tech_awareness_actual} | ${global_tech_awareness_required} | ${global_tech_awareness_gap}
Physical Security             | ${physical_security_atasan}     | ${physical_security_self}   | ${physical_security_rekan_kerja}     | ${physical_security_actual}     | ${physical_security_required}     | ${physical_security_gap}
Practical Security            | ${practical_security_atasan}    | ${practical_security_self}  | ${practical_security_rekan_kerja}    | ${practical_security_actual}    | ${practical_security_required}    | ${practical_security_gap}
Cyber Security                | ${cyber_security_atasan}        | ${cyber_security_self}      | ${cyber_security_rekan_kerja}        | ${cyber_security_actual}        | ${cyber_security_required}        | ${cyber_security_gap}
Investigation & Case Management | ${investigation_case_mgmt_atasan} | ${investigation_case_mgmt_self} | ${investigation_case_mgmt_rekan_kerja} | ${investigation_case_mgmt_actual} | ${investigation_case_mgmt_required} | ${investigation_case_mgmt_gap}
Business Intelligence         | ${business_intelligence_atasan} | ${business_intelligence_self}| ${business_intelligence_rekan_kerja} | ${business_intelligence_actual} | ${business_intelligence_required} | ${business_intelligence_gap}
Basic Intelligence            | ${basic_intelligence_atasan}    | ${basic_intelligence_self}  | ${basic_intelligence_rekan_kerja}    | ${basic_intelligence_actual}    | ${basic_intelligence_required}    | ${basic_intelligence_gap}
Mass & Conflict Management    | ${mass_conflict_mgmt_atasan}    | ${mass_conflict_mgmt_self}  | ${mass_conflict_mgmt_rekan_kerja}    | ${mass_conflict_mgmt_actual}    | ${mass_conflict_mgmt_required}    | ${mass_conflict_mgmt_gap}
Legal & Compliance            | ${legal_compliance_atasan}      | ${legal_compliance_self}    | ${legal_compliance_rekan_kerja}      | ${legal_compliance_actual}      | ${legal_compliance_required}      | ${legal_compliance_gap}
Disaster Management           | ${disaster_management_atasan}   | ${disaster_management_self} | ${disaster_management_rekan_kerja}   | ${disaster_management_actual}   | ${disaster_management_required}   | ${disaster_management_gap}
SAR                          | ${sar_atasan}                   | ${sar_self}                 | ${sar_rekan_kerja}                   | ${sar_actual}                   | ${sar_required}                   | ${sar_gap}
Assessor                     | ${assessor_atasan}              | ${assessor_self}            | ${assessor_rekan_kerja}              | ${assessor_actual}              | ${assessor_required}              | ${assessor_gap}
```

## Manual Steps Required:

### 1. Open Template in Microsoft Word
```
File: /Users/allyviomahardhika/Documents/Code/Peopleshift/assessment-engine/storage/app/template/template_2.docx
```

### 2. Find Gap Analysis Table
Look for table with header:
- "Kompetensi", "Atasan", "Diri", "Rekan Kerja", "Actual Level", "Required Level", "Gap"

### 3. Update Header Row
Change percentages:
- ❌ "Atasan (60%)" → ✅ "Atasan (35%)"
- ❌ "Diri (20%)" → ✅ "Diri (15%)" 
- ❌ "Rekan Kerja (20%)" → ✅ "Rekan Kerja (50%)"

### 4. Replace All Static Data with Variables
For each row in the table, replace:
- Static numbers → Dynamic variables as shown above
- Keep competency names as text (Risk Management, Business Continuity, etc.)

### 5. Save Template
Save the modified template_2.docx

## Alternative: Create New Template
If modifying existing template is difficult, create new template with proper structure.

## Verification
After template modification:
1. Download report for participant 91
2. Check if data matches web app:
   - Atasan: 1.0
   - Diri: 3.0  
   - Rekan Kerja: 1.5
   - Actual Level: 1.55
   - Required Level: 3
   - Gap: -1.45 (Below Required)

## Controller Status
✅ Controller logic sudah benar dan siap
✅ All variables akan ter-populate dengan data yang benar
❌ **Template perlu dimodifikasi manual untuk menggunakan variables**