# Template_2.docx Fix Instructions

## Problem Identified
Template `template_2.docx` tidak memiliki struktur tabel dinamis yang diperlukan untuk PhpWord `cloneRow()` functionality. 

Current template hanya memiliki:
- Static table dengan data hardcoded 
- Wrong percentages (60%-20%-20% instead of 35%-15%-50%)
- Variables: `nama_karyawan`, `departemen`, `fungsi` saja

## Required Fix

### 1. Update Template Structure
Template perlu dimodifikasi dengan struktur tabel seperti ini:

**Header Row:**
| No. | Kompetensi | Atasan(35%) | Diri(15%) | Rekan Kerja(50%) | Actual Level | Required Level | Gap |

**Data Row (Row 2 - untuk cloning):**
| ${nomor} | ${kompetensi} | ${atasan} | ${self} | ${rekan_kerja} | ${actual_level} | ${required_level} | ${gap} |

### 2. Variable Structure Needed
Template harus memiliki variables yang dapat di-clone:
- `${nomor#1}`, `${nomor#2}`, etc.
- `${kompetensi#1}`, `${kompetensi#2}`, etc.  
- `${atasan#1}`, `${atasan#2}`, etc.
- `${self#1}`, `${self#2}`, etc.
- `${rekan_kerja#1}`, `${rekan_kerja#2}`, etc.
- `${actual_level#1}`, `${actual_level#2}`, etc.
- `${required_level#1}`, `${required_level#2}`, etc.
- `${gap#1}`, `${gap#2}`, etc.

### 3. How to Create in Microsoft Word

1. **Open template_2.docx in Microsoft Word**
2. **Find the existing table with gap analysis data**
3. **Replace table structure:**
   - Header row: "No.", "Kompetensi", "Atasan(35%)", "Diri(15%)", "Rekan Kerja(50%)", "Actual Level", "Required Level", "Gap"
   - Data row (row 2): Insert the variables exactly as shown above
4. **Save the template**

### 4. Alternative Solution - Fallback Method
If template modification is not possible, we can update the controller to use basic variable replacement instead of table cloning.

## Current Status
- ✅ Controller logic is correct (35%-15%-50%)
- ✅ Data calculation is accurate  
- ❌ Template structure doesn't support dynamic tables
- ❌ Template has wrong percentages in static content

## Next Steps
1. Modify template_2.docx structure for dynamic table support
2. Test report generation with participant 91
3. Verify all 15 competencies populate correctly