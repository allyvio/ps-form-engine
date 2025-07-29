# Template Variables Required for Gap Analysis Report

## Problem Solved
✅ **Fixed static data issue in template_2.docx**
- Template sekarang menggunakan data dinamis dari database
- Persentase sudah benar: Atasan(35%) + Diri(15%) + Rekan Kerja(50%)
- Controller menggunakan fallback method untuk individual variable replacement

## Required Variables in Template_2.docx

### Basic Information
- `${nama_karyawan}` - Nama peserta
- `${departemen}` - Department dari gap analysis  
- `${fungsi}` - Function dari gap analysis

### Per Competency Variables (15 competencies total)

Untuk setiap kompetensi, template harus memiliki variables:

#### 1. Risk Management
- `${risk_management_atasan}` - Rating dari atasan (35%)
- `${risk_management_self}` - Rating diri sendiri (15%)  
- `${risk_management_rekan_kerja}` - Rating rekan kerja (50%)
- `${risk_management_actual}` - Actual level hasil weighted calculation
- `${risk_management_required}` - Required level dari competency matrix
- `${risk_management_gap}` - Gap dengan interpretasi (Above/Below/Meets Required)

#### 2. Business Continuity
- `${business_continuity_atasan}`
- `${business_continuity_self}`
- `${business_continuity_rekan_kerja}`
- `${business_continuity_actual}`
- `${business_continuity_required}`
- `${business_continuity_gap}`

#### 3. Personnel Management
- `${personnel_management_atasan}`
- `${personnel_management_self}`
- `${personnel_management_rekan_kerja}`
- `${personnel_management_actual}`
- `${personnel_management_required}`
- `${personnel_management_gap}`

#### 4. Global & Technological Awareness
- `${global_tech_awareness_atasan}`
- `${global_tech_awareness_self}`
- `${global_tech_awareness_rekan_kerja}`
- `${global_tech_awareness_actual}`
- `${global_tech_awareness_required}`
- `${global_tech_awareness_gap}`

#### 5. Physical Security
- `${physical_security_atasan}`
- `${physical_security_self}`
- `${physical_security_rekan_kerja}`
- `${physical_security_actual}`
- `${physical_security_required}`
- `${physical_security_gap}`

#### 6. Practical Security
- `${practical_security_atasan}`
- `${practical_security_self}`
- `${practical_security_rekan_kerja}`
- `${practical_security_actual}`
- `${practical_security_required}`
- `${practical_security_gap}`

#### 7. Cyber Security
- `${cyber_security_atasan}`
- `${cyber_security_self}`
- `${cyber_security_rekan_kerja}`
- `${cyber_security_actual}`
- `${cyber_security_required}`
- `${cyber_security_gap}`

#### 8. Investigation & Case Management
- `${investigation_case_mgmt_atasan}`
- `${investigation_case_mgmt_self}`
- `${investigation_case_mgmt_rekan_kerja}`
- `${investigation_case_mgmt_actual}`
- `${investigation_case_mgmt_required}`
- `${investigation_case_mgmt_gap}`

#### 9. Business Intelligence
- `${business_intelligence_atasan}`
- `${business_intelligence_self}`
- `${business_intelligence_rekan_kerja}`
- `${business_intelligence_actual}`
- `${business_intelligence_required}`
- `${business_intelligence_gap}`

#### 10. Basic Intelligence
- `${basic_intelligence_atasan}`
- `${basic_intelligence_self}`
- `${basic_intelligence_rekan_kerja}`
- `${basic_intelligence_actual}`
- `${basic_intelligence_required}`
- `${basic_intelligence_gap}`

#### 11. Mass & Conflict Management
- `${mass_conflict_mgmt_atasan}`
- `${mass_conflict_mgmt_self}`
- `${mass_conflict_mgmt_rekan_kerja}`
- `${mass_conflict_mgmt_actual}`
- `${mass_conflict_mgmt_required}`
- `${mass_conflict_mgmt_gap}`

#### 12. Legal & Compliance
- `${legal_compliance_atasan}`
- `${legal_compliance_self}`
- `${legal_compliance_rekan_kerja}`
- `${legal_compliance_actual}`
- `${legal_compliance_required}`
- `${legal_compliance_gap}`

#### 13. Disaster Management
- `${disaster_management_atasan}`
- `${disaster_management_self}`
- `${disaster_management_rekan_kerja}`
- `${disaster_management_actual}`
- `${disaster_management_required}`
- `${disaster_management_gap}`

#### 14. SAR
- `${sar_atasan}`
- `${sar_self}`
- `${sar_rekan_kerja}`
- `${sar_actual}`
- `${sar_required}`
- `${sar_gap}`

#### 15. Assessor
- `${assessor_atasan}`
- `${assessor_self}`
- `${assessor_rekan_kerja}`
- `${assessor_actual}`
- `${assessor_required}`
- `${assessor_gap}`

## Expected Data Format

### Role-based Ratings
- Format: `1.0`, `2.5`, `3.0`, etc. (satu desimal)
- "No Data" jika tidak ada assessment untuk role tersebut

### Actual Level
- Format: `1.55`, `2.73`, etc. (dua desimal)
- Hasil weighted calculation: (Atasan × 35%) + (Diri × 15%) + (Rekan Kerja × 50%)

### Required Level  
- Format: `3`, `4`, etc. (integer dari competency matrix)
- `N/A` jika tidak ada data di matrix

### Gap
- Format: `-1.45 (Below Required)`, `+0.25 (Above Required)`, `0.00 (Meets Required)`
- Calculation: Actual - Required
- Positive = Above Required (surplus)
- Negative = Below Required (deficit)
- Zero = Meets Required

## Implementation Status
✅ Controller logic updated with fallback method  
✅ All 15 competencies supported
✅ Correct weighted calculation (35%-15%-50%)
✅ User-friendly gap interpretation
✅ Error handling for missing data

## Testing
✅ Tested with participant ID 91 (Sri Mandala Pranata)
✅ Variables correctly populated with dynamic data
✅ Download functionality working

## Next Steps  
1. ✅ Update template_2.docx dengan variables di atas
2. ✅ Test dengan berbagai participants  
3. ✅ Verify semua 15 competencies muncul dengan benar