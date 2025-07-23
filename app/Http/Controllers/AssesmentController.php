<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\FormOtherAstra;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;

class AssesmentController extends Controller
{
    public function listPeserta()
    {
        $breadcrumb1 = 'List Peserta';
        $breadcrumb2 = null;
        $button = false;
        $data = Peserta::all();
        return view('astra.page.peserta.list', compact('breadcrumb1', 'breadcrumb2', 'button', 'data'));
    }

    public function detailPeserta($id)
    {
        $breadcrumb1 = 'List Peserta';
        $breadcrumb2 = 'Detail Peserta';
        $button = false;
        $detailPeserta = Peserta::find($id);
        $dataTable = FormOtherAstra::where('rater_for_id', $id)->get();
        $countPenilai = FormOtherAstra::where('rater_for_id', $id)->count();
        $calculateAtasan = $this->calculateFormOthers($dataTable, "Atasan");
        $calculateRekanKerja = $this->calculateFormOthers($dataTable, "Rekan Kerja");
        $calculateSelf = $this->calculateFormOthers($dataTable, "Self");
        $calculateActualLevel= $this->calculateActualLevel($calculateAtasan, $calculateRekanKerja, $calculateSelf);
        $calculateGap = $this->calculateGap($calculateActualLevel,'Strategic Business Intelligence');
        return view('astra.page.upload.detailPeserta', compact('breadcrumb1', 'breadcrumb2', 'button', 'dataTable', 'detailPeserta', 'countPenilai', 'calculateAtasan', 'calculateSelf','calculateRekanKerja', 'calculateActualLevel','calculateGap'));
    }

    public function downloadReport(){
        $templatePath = storage_path('app/template/template_3.docx');
        if (!file_exists($templatePath)) {
            abort(404, "Template tidak ditemukan");
        }
    
        // Buat instance TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);
    
        // Set variabel dalam dokumen
        $templateProcessor->setValue('nama_karyawan', "Sri Mandala Pranata");
        $templateProcessor->setValue('departemen', 'BIZTEL');
        $templateProcessor->setValue('fungsi', 'ASA ACADEMY');
    
        // Simpan dokumen hasil pengisian variabel
        $outputFile = storage_path('app/laporan_asesmen_' . 'sri_mandala_pranata' . '.docx');
        $templateProcessor->saveAs($outputFile);
    
        // Beri respons file untuk diunduh
        return response()->download($outputFile)->deleteFileAfterSend(true);
    }

    private function calculateFormOthers($data, $role)
    {
        $filteredData = $data->where('rater_from_role', $role);
        
        if ($filteredData->isEmpty()) {
            return array_fill_keys([
                'risk_management', 'business_continuity', 'personnel_management', 
                'global_technological_awareness', 'physical_security', 'practical_security',
                'cyber_security', 'investigation_case_management', 'business_intelligence',
                'basic_intelligence', 'mass_conflict_management', 'legal_compliance',
                'disaster_management', 'search_and_rescue', 'assessor'
            ], 0);
        }

        $averages = [];
        $fields = [
            'risk_management', 'business_continuity', 'personnel_management',
            'global_technological_awareness', 'physical_security', 'practical_security',
            'cyber_security', 'investigation_case_management', 'business_intelligence',
            'basic_intelligence', 'mass_conflict_management', 'legal_compliance',
            'disaster_management', 'search_and_rescue', 'assessor'
        ];

        foreach ($fields as $field) {
            $averages[$field] = $filteredData->avg($field);
        }

        return $averages;
    }

    private function calculateActualLevel($atasan, $rekanKerja, $self)
    {
        $actualLevel = [];
        $fields = [
            'risk_management', 'business_continuity', 'personnel_management',
            'global_technological_awareness', 'physical_security', 'practical_security',
            'cyber_security', 'investigation_case_management', 'business_intelligence',
            'basic_intelligence', 'mass_conflict_management', 'legal_compliance',
            'disaster_management', 'search_and_rescue', 'assessor'
        ];

        foreach ($fields as $field) {
            $actualLevel[$field] = ($atasan[$field] * 0.6) + ($rekanKerja[$field] * 0.2) + ($self[$field] * 0.2);
        }

        return $actualLevel;
    }

    private function calculateGap($actualLevel, $position)
    {
        $matrixPath = storage_path('app/competencies/matrix.json');
        $matrixData = json_decode(file_get_contents($matrixPath), true);
        
        $positionData = collect($matrixData)->firstWhere('position', $position);
        if (!$positionData) {
            return array_fill_keys(array_keys($actualLevel), 0);
        }

        $gap = [];
        foreach ($actualLevel as $competency => $actual) {
            $required = $positionData['competencies'][$competency] ?? 0;
            $gap[$competency] = $required - $actual;
        }

        return $gap;
    }
}