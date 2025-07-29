# Template Table Structure untuk Gap Analysis Report

## Overview
Untuk membuat tabel "Tanggapan Survei dilihat berdasarkan Gap Kompetensi" dinamis di template_2.docx, template Word perlu dimodifikasi dengan struktur tabel yang sesuai.

## Struktur Tabel yang Diperlukan

### Header Tabel:
| No. | Kompetensi | Atasan(35%) | Diri(15%) | Rekan Kerja(50%) | Actual Level | Required Level | Gap |

### Template Variables untuk Tabel:
Dalam template_2.docx, buat tabel dengan variabel berikut di baris kedua (data row):

```
${nomor}       | ${kompetensi}    | ${atasan}     | ${self}     | ${rekan_kerja}    | ${actual_level} | ${required_level} | ${gap}
```

### Cara Membuat di Word:
1. Buka template_2.docx di Microsoft Word
2. Tambahkan tabel dengan 8 kolom
3. Header row: "No.", "Kompetensi", "Atasan(35%)", "Diri(15%)", "Rekan Kerja(50%)", "Actual Level", "Required Level", "Gap"
4. Data row (baris ke-2): Masukkan variables seperti di atas
5. Simpan template

## Variables yang Akan Diisi Dinamis:

### Basic Info:
- `${nama_karyawan}` - Nama peserta
- `${departemen}` - Department dari gap analysis
- `${fungsi}` - Function dari gap analysis

### Table Data (per row):
- `${nomor#1}`, `${nomor#2}`, dst - Nomor urut (1, 2, 3...)
- `${kompetensi#1}`, `${kompetensi#2}`, dst - Nama kompetensi
- `${atasan#1}`, `${atasan#2}`, dst - Rating dari atasan (35%)
- `${self#1}`, `${self#2}`, dst - Rating diri sendiri (15%)
- `${rekan_kerja#1}`, `${rekan_kerja#2}`, dst - Rating rekan kerja (50%)
- `${actual_level#1}`, `${actual_level#2}`, dst - Actual level hasil weighted
- `${required_level#1}`, `${required_level#2}`, dst - Required level dari matrix
- `${gap#1}`, `${gap#2}`, dst - Gap calculation dengan interpretasi

## Data yang Akan Muncul:

### 15 Kompetensi:
1. Risk Management
2. Business Continuity
3. Personnel Management
4. Global & Technological Awareness
5. Physical Security
6. Practical Security
7. Cyber Security
8. Investigation & Case Management
9. Business Intelligence
10. Basic Intelligence
11. Mass & Conflict Management
12. Legal & Compliance
13. Disaster Management
14. SAR
15. Assessor

### Gap Display Format:
- `+X.XX (Above Required)` - Jika actual > required
- `-X.XX (Below Required)` - Jika actual < required  
- `0.00 (Meets Required)` - Jika actual = required
- `N/A` - Jika data tidak tersedia

## Implementation Status:
✅ Controller method sudah siap dengan dynamic table support
✅ Semua 15 kompetensi data preparation
✅ Role-based rating calculation (Atasan, Diri, Rekan Kerja)
✅ Gap calculation dengan format yang user-friendly
✅ Error handling jika template tidak memiliki tabel

## Next Steps:
1. Modifikasi template_2.docx dengan struktur tabel di atas
2. Test download report untuk memastikan tabel terisi dengan benar
3. Adjust formatting sesuai kebutuhan (borders, alignment, etc.)