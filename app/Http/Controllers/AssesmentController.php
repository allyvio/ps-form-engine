<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\FormOtherAstra;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Services\RecommendationService;

class AssesmentController extends Controller
{
    public function listPeserta()
    {
        $breadcrumb1 = 'List Peserta';
        $breadcrumb2 = null;
        $button = false;
        
        // Get peserta with their department and function from form_other_astras
        $data = Peserta::leftJoin('form_other_astras', 'peserta.id', '=', 'form_other_astras.reviewee_id')
            ->select('peserta.*', 
                DB::raw('MAX(form_other_astras.departemen) as departemen'),
                DB::raw('MAX(form_other_astras.fungsi) as fungsi'))
            ->groupBy('peserta.id', 'peserta.name', 'peserta.email', 'peserta.created_at', 'peserta.updated_at')
            ->orderBy('id')
            ->get();

        // Calculate statistics
        $totalPeserta = Peserta::count();
        $totalAssessments = DB::table('form_other_astras')->count();
        $totalReviewers = DB::table('form_other_astras')->distinct('reviewer_id')->count();
        $completedAssessments = DB::table('gap_analysis')->count();
            
        return view('astra.page.peserta.list', compact('breadcrumb1', 'breadcrumb2', 'button', 'data', 'totalPeserta', 'totalAssessments', 'totalReviewers', 'completedAssessments'));
    }

    public function detailPeserta($id)
    {
        $breadcrumb1 = 'List Peserta';
        $breadcrumb2 = 'Detail Peserta';
        $button = false;
        $detailPeserta = Peserta::find($id);
        
        // Get assessments and join with reviewer_assignments to get correct roles
        $dataTable = \Illuminate\Support\Facades\DB::table('form_other_astras as f')
            ->leftJoin('reviewer_assignments as r', function($join) use ($id) {
                $join->on('f.reviewer_id', '=', 'r.reviewer_id')
                     ->where('r.reviewee_id', '=', $id);
            })
            ->where('f.reviewee_id', $id)
            ->select('f.*', 'r.reviewer_role as assigned_role')
            ->get();
        
        // Add proper role mapping based on reviewer_assignments
        $dataTable = $dataTable->map(function($assessment) {
            // Use assigned_role if available, otherwise fall back to original peran for legacy data
            $assessment->display_role = $assessment->assigned_role ?: $assessment->peran;
            
            // Map individual roles to display categories for backward compatibility
            if ($assessment->assigned_role) {
                switch ($assessment->assigned_role) {
                    case 'Atasan Langsung':
                        $assessment->category_role = 'atasan';
                        break;
                    case 'Diri Sendiri':
                        $assessment->category_role = 'self';
                        break;
                    case 'Rekan Kerja 1':
                    case 'Rekan Kerja 2':
                        $assessment->category_role = 'rekan_kerja';
                        break;
                    case 'Bawahan Langsung 1':
                    case 'Bawahan Langsung 2':
                        $assessment->category_role = 'bawahan';
                        break;
                    default:
                        $assessment->category_role = 'unknown';
                }
            } else {
                // Legacy data - use original logic
                if ($assessment->reviewer_name === $assessment->reviewee_name) {
                    $assessment->category_role = 'self';
                } elseif (strtolower($assessment->peran) === 'atasan') {
                    $assessment->category_role = 'atasan';
                } elseif (in_array(strtolower($assessment->peran), ['rekan kerja', 'bawahan'])) {
                    $assessment->category_role = 'rekan_kerja';
                } else {
                    $assessment->category_role = 'unknown';
                }
            }
            
            return $assessment;
        });
        
        $countPenilai = $dataTable->count();
        
        // Get gap analysis from database
        $gapAnalysis = \App\Models\GapAnalysis::where('reviewee_id', $id)->first();
        
        // If no gap analysis exists, generate it on demand
        if (!$gapAnalysis) {
            try {
                $gapAnalysisService = new \App\Services\GapAnalysisService();
                $gapAnalysis = $gapAnalysisService->generateGapAnalysisForReviewee($id);
            } catch (\Exception $e) {
                // Fallback to old calculation if gap analysis fails
                $calculateAtasan = $this->calculateFormOthers($dataTable, "Atasan");
                $calculateRekanKerja = $this->calculateFormOthers($dataTable, "Rekan Kerja");
                $calculateSelf = $this->calculateFormOthers($dataTable, "Self");
                $calculateActualLevel = $this->calculateActualLevel($calculateAtasan, $calculateRekanKerja, $calculateSelf);
                $calculateGap = $this->calculateGap($calculateActualLevel, 'Strategic Business Intelligence');
                
                return view('astra.page.upload.detailPeserta', compact('breadcrumb1', 'breadcrumb2', 'button', 'dataTable', 'detailPeserta', 'countPenilai', 'calculateAtasan', 'calculateSelf','calculateRekanKerja', 'calculateActualLevel','calculateGap'));
            }
        }
        
        // If gap analysis is still null after generation attempt, handle gracefully
        if (!$gapAnalysis) {
            // Return view with basic data and no gap analysis
            return view('astra.page.upload.detailPeserta', [
                'breadcrumb1' => $breadcrumb1,
                'breadcrumb2' => $breadcrumb2,
                'button' => $button,
                'dataTable' => $dataTable,
                'detailPeserta' => $detailPeserta,
                'countPenilai' => $countPenilai,
                'gapAnalysis' => null,
                'competencies' => [],
                'overallActualLevel' => 'N/A',
                'roleBreakdown' => ['atasan' => ['count' => 0], 'self' => ['count' => 0], 'rekan_kerja' => ['count' => 0]],
                'individualRoleBreakdown' => [],
                'mergedRoleBreakdown' => [
                    'atasan' => ['actual_weight' => 0, 'assessments' => collect()],
                    'diri' => ['actual_weight' => 0, 'assessments' => collect()],
                    'rekan_kerja' => ['actual_weight' => 0, 'assessments' => collect()],
                    'bawahan' => ['actual_weight' => 0, 'assessments' => collect()]
                ],
                'competencyMapping' => [],
                'recommendation' => [
                    'percentage' => 0, 
                    'category' => 'Data tidak tersedia', 
                    'description' => 'Tidak ada data assessment untuk peserta ini',
                    'competencies_met' => 0,
                    'total_required' => 0,
                    'competencies_need_development' => 0
                ],
                'competencyBreakdown' => [],
                'recommendationColor' => 'secondary',
                'competencyRankings' => ['top3' => [], 'bottom3' => []]
            ]);
        }
        
        // Competency field mapping
        $competencyMapping = [
            'Risk Management' => 'risk_management',
            'Business Continuity' => 'business_continuity', 
            'Personnel Management' => 'personnel_management',
            'Global & Technological Awareness' => 'global_tech_awareness',
            'Physical Security' => 'physical_security',
            'Practical Security' => 'practical_security',
            'Cyber Security' => 'cyber_security',
            'Investigation & Case Management' => 'investigation_case_mgmt',
            'Business Intelligence' => 'business_intelligence',
            'Basic Intelligence' => 'basic_intelligence',
            'Mass & Conflict Management' => 'mass_conflict_mgmt',
            'Legal & Compliance' => 'legal_compliance',
            'Disaster Management' => 'disaster_management',
            'SAR' => 'sar',
            'Assessor' => 'assessor'
        ];
        
        // Prepare competency data for the view
        $competencies = [
            'Risk Management' => [
                'actual' => $gapAnalysis->risk_management_actual,
                'expected' => $gapAnalysis->risk_management_expected,
                'gap' => $gapAnalysis->risk_management_gap
            ],
            'Business Continuity' => [
                'actual' => $gapAnalysis->business_continuity_actual,
                'expected' => $gapAnalysis->business_continuity_expected,
                'gap' => $gapAnalysis->business_continuity_gap
            ],
            'Personnel Management' => [
                'actual' => $gapAnalysis->personnel_management_actual,
                'expected' => $gapAnalysis->personnel_management_expected,
                'gap' => $gapAnalysis->personnel_management_gap
            ],
            'Global & Technological Awareness' => [
                'actual' => $gapAnalysis->global_tech_awareness_actual,
                'expected' => $gapAnalysis->global_tech_awareness_expected,
                'gap' => $gapAnalysis->global_tech_awareness_gap
            ],
            'Physical Security' => [
                'actual' => $gapAnalysis->physical_security_actual,
                'expected' => $gapAnalysis->physical_security_expected,
                'gap' => $gapAnalysis->physical_security_gap
            ],
            'Practical Security' => [
                'actual' => $gapAnalysis->practical_security_actual,
                'expected' => $gapAnalysis->practical_security_expected,
                'gap' => $gapAnalysis->practical_security_gap
            ],
            'Cyber Security' => [
                'actual' => $gapAnalysis->cyber_security_actual,
                'expected' => $gapAnalysis->cyber_security_expected,
                'gap' => $gapAnalysis->cyber_security_gap
            ],
            'Investigation & Case Management' => [
                'actual' => $gapAnalysis->investigation_case_mgmt_actual,
                'expected' => $gapAnalysis->investigation_case_mgmt_expected,
                'gap' => $gapAnalysis->investigation_case_mgmt_gap
            ],
            'Business Intelligence' => [
                'actual' => $gapAnalysis->business_intelligence_actual,
                'expected' => $gapAnalysis->business_intelligence_expected,
                'gap' => $gapAnalysis->business_intelligence_gap
            ],
            'Basic Intelligence' => [
                'actual' => $gapAnalysis->basic_intelligence_actual,
                'expected' => $gapAnalysis->basic_intelligence_expected,
                'gap' => $gapAnalysis->basic_intelligence_gap
            ],
            'Mass & Conflict Management' => [
                'actual' => $gapAnalysis->mass_conflict_mgmt_actual,
                'expected' => $gapAnalysis->mass_conflict_mgmt_expected,
                'gap' => $gapAnalysis->mass_conflict_mgmt_gap
            ],
            'Legal & Compliance' => [
                'actual' => $gapAnalysis->legal_compliance_actual,
                'expected' => $gapAnalysis->legal_compliance_expected,
                'gap' => $gapAnalysis->legal_compliance_gap
            ],
            'Disaster Management' => [
                'actual' => $gapAnalysis->disaster_management_actual,
                'expected' => $gapAnalysis->disaster_management_expected,
                'gap' => $gapAnalysis->disaster_management_gap
            ],
            'SAR' => [
                'actual' => $gapAnalysis->sar_actual,
                'expected' => $gapAnalysis->sar_expected,
                'gap' => $gapAnalysis->sar_gap
            ],
            'Assessor' => [
                'actual' => $gapAnalysis->assessor_actual,
                'expected' => $gapAnalysis->assessor_expected,
                'gap' => $gapAnalysis->assessor_gap
            ]
        ];
        
        // Calculate overall actual level (average of non-null actual values)
        $actualLevels = array_filter(array_column($competencies, 'actual'), function($val) { return $val !== null; });
        $overallActualLevel = !empty($actualLevels) ? round(array_sum($actualLevels) / count($actualLevels), 1) : 0;
        
        // NEW: Calculate individual role breakdown based on reviewer_assignments
        $assignments = \Illuminate\Support\Facades\DB::table('reviewer_assignments')
            ->where('reviewee_id', $id)
            ->get()
            ->keyBy('reviewer_role');
        
        $individualRoleBreakdown = [];
        
        // Process each assigned role for individual tracking
        foreach (['Atasan Langsung', 'Diri Sendiri', 'Rekan Kerja 1', 'Rekan Kerja 2', 'Bawahan Langsung 1', 'Bawahan Langsung 2'] as $role) {
            $assignment = $assignments->get($role);
            
            if ($assignment) {
                $reviewer = \App\Models\Peserta::find($assignment->reviewer_id);
                $assessment = $dataTable->where('reviewer_id', $assignment->reviewer_id)->first();
                
                $individualRoleBreakdown[$role] = [
                    'reviewer_name' => $reviewer ? $reviewer->name : 'Unknown',
                    'assessment' => $assessment,
                    'has_assessment' => $assessment !== null
                ];
            } else {
                $individualRoleBreakdown[$role] = [
                    'reviewer_name' => 'Not Assigned',
                    'assessment' => null,
                    'has_assessment' => false
                ];
            }
        }
        
        // Create merged role breakdown for display with dynamic weights
        $mergedRoleBreakdown = [
            'atasan' => [
                'assessments' => collect(),
                'base_weight' => 10,
                'actual_weight' => 10
            ],
            'diri' => [
                'assessments' => collect(),
                'base_weight' => 50,
                'actual_weight' => 50
            ],
            'rekan_kerja' => [
                'assessments' => collect(),
                'base_weight' => 20, // RK1 + RK2
                'actual_weight' => 20
            ],
            'bawahan' => [
                'assessments' => collect(),
                'base_weight' => 20, // B1 + B2
                'actual_weight' => 20
            ]
        ];
        
        // Group individual assessments into merged categories
        if (isset($individualRoleBreakdown['Atasan Langsung']['assessment'])) {
            $mergedRoleBreakdown['atasan']['assessments']->push($individualRoleBreakdown['Atasan Langsung']['assessment']);
        }
        
        if (isset($individualRoleBreakdown['Diri Sendiri']['assessment'])) {
            $mergedRoleBreakdown['diri']['assessments']->push($individualRoleBreakdown['Diri Sendiri']['assessment']);
        }
        
        foreach (['Rekan Kerja 1', 'Rekan Kerja 2'] as $role) {
            if (isset($individualRoleBreakdown[$role]['assessment'])) {
                $mergedRoleBreakdown['rekan_kerja']['assessments']->push($individualRoleBreakdown[$role]['assessment']);
            }
        }
        
        foreach (['Bawahan Langsung 1', 'Bawahan Langsung 2'] as $role) {
            if (isset($individualRoleBreakdown[$role]['assessment'])) {
                $mergedRoleBreakdown['bawahan']['assessments']->push($individualRoleBreakdown[$role]['assessment']);
            }
        }
        
        // Calculate actual weights based on individual assessments first
        $mergedRoleBreakdown['atasan']['actual_weight'] = $mergedRoleBreakdown['atasan']['assessments']->isNotEmpty() ? 10 : 0;
        $mergedRoleBreakdown['diri']['actual_weight'] = $mergedRoleBreakdown['diri']['assessments']->isNotEmpty() ? 50 : 0;
        $mergedRoleBreakdown['rekan_kerja']['actual_weight'] = $mergedRoleBreakdown['rekan_kerja']['assessments']->count() * 10; // Each assessment = 10%
        $mergedRoleBreakdown['bawahan']['actual_weight'] = $mergedRoleBreakdown['bawahan']['assessments']->count() * 10; // Each assessment = 10%
        
        // Calculate actual weights with redistribution logic
        $missingWeights = 0;
        $selfHasData = $mergedRoleBreakdown['diri']['assessments']->isNotEmpty();
        
        // Check which roles are missing and calculate redistribution
        if ($mergedRoleBreakdown['atasan']['assessments']->isEmpty()) {
            $missingWeights += $mergedRoleBreakdown['atasan']['base_weight'];
            $mergedRoleBreakdown['atasan']['actual_weight'] = 0;
        }
        
        if ($mergedRoleBreakdown['rekan_kerja']['assessments']->isEmpty()) {
            $missingWeights += $mergedRoleBreakdown['rekan_kerja']['base_weight'];
            $mergedRoleBreakdown['rekan_kerja']['actual_weight'] = 0;
        }
        
        if ($mergedRoleBreakdown['bawahan']['assessments']->isEmpty()) {
            $missingWeights += $mergedRoleBreakdown['bawahan']['base_weight'];
            $mergedRoleBreakdown['bawahan']['actual_weight'] = 0;
        }
        
        // If self has data, redistribute missing weights to self
        if ($selfHasData && $missingWeights > 0) {
            $mergedRoleBreakdown['diri']['actual_weight'] += $missingWeights;
        } elseif (!$selfHasData) {
            // If self also missing, it gets 0%
            $mergedRoleBreakdown['diri']['actual_weight'] = 0;
        }
        
        // LEGACY: Keep old grouped breakdown for backward compatibility
        $roleBreakdown = [
            'atasan' => ['count' => 0, 'assessments' => collect()],
            'self' => ['count' => 0, 'assessments' => collect()],
            'rekan_kerja' => ['count' => 0, 'assessments' => collect()]
        ];
        
        foreach ($dataTable as $assessment) {
            // Use the new category_role that's based on reviewer_assignments
            switch ($assessment->category_role) {
                case 'self':
                    $roleBreakdown['self']['assessments']->push($assessment);
                    $roleBreakdown['self']['count']++;
                    break;
                case 'atasan':
                    $roleBreakdown['atasan']['assessments']->push($assessment);
                    $roleBreakdown['atasan']['count']++;
                    break;
                case 'rekan_kerja':
                case 'bawahan':
                    $roleBreakdown['rekan_kerja']['assessments']->push($assessment);
                    $roleBreakdown['rekan_kerja']['count']++;
                    break;
            }
        }
        
        // Calculate recommendation based on competency fulfillment
        $recommendationService = new RecommendationService();
        $recommendation = $recommendationService->calculateRecommendation($gapAnalysis);
        $competencyBreakdown = $recommendationService->getCompetencyBreakdown($gapAnalysis);
        $recommendationColor = $recommendationService->getRecommendationColor($recommendation['percentage']);
        
        // Calculate top 3 and bottom 3 competencies by gap
        $competencyRankings = $this->calculateCompetencyRankings($competencyBreakdown);
        
        return view('astra.page.upload.detailPeserta', compact('breadcrumb1', 'breadcrumb2', 'button', 'dataTable', 'detailPeserta', 'countPenilai', 'gapAnalysis', 'competencies', 'overallActualLevel', 'roleBreakdown', 'individualRoleBreakdown', 'mergedRoleBreakdown', 'competencyMapping', 'recommendation', 'competencyBreakdown', 'recommendationColor', 'competencyRankings'));
    }

    public function reviewerAssignments()
    {
        $breadcrumb1 = 'Reviewer Assignments';
        $breadcrumb2 = null;
        $button = false;
        
        // Get all reviewer assignments with counts
        $assignments = DB::table('reviewer_assignments')
            ->orderBy('reviewee_id')
            ->orderBy('reviewer_role')
            ->get()
            ->groupBy('reviewee_id');
            
        return view('astra.page.reviewer.assignments', compact('breadcrumb1', 'breadcrumb2', 'button', 'assignments'));
    }

    public function assessmentData()
    {
        $breadcrumb1 = 'Assessment Data';
        $breadcrumb2 = null;
        $button = false;
        
        // Get assessment data with relationships
        $assessments = FormOtherAstra::with(['reviewer', 'reviewee'])
            ->orderBy('submission_date', 'desc')
            ->paginate(20);
            
        // Get summary stats
        $stats = [
            'total_assessments' => FormOtherAstra::count(),
            'total_reviewers' => FormOtherAstra::distinct('reviewer_id')->count(),
            'total_reviewees' => FormOtherAstra::distinct('reviewee_id')->count(),
            'departments' => FormOtherAstra::distinct('departemen')->pluck('departemen')->filter()
        ];
            
        return view('astra.page.assessment.data', compact('breadcrumb1', 'breadcrumb2', 'button', 'assessments', 'stats'));
    }

    public function assessmentDetail($id)
    {
        $breadcrumb1 = 'Assessment Data';
        $breadcrumb2 = 'Detail Assessment';
        $button = false;
        
        $assessment = FormOtherAstra::with(['reviewer', 'reviewee'])->findOrFail($id);
        
        // Competency data mapping
        $competencies = [
            'Risk Management' => [
                'rating' => $assessment->risk_management_rating,
                'narrative' => $assessment->risk_management_narrative
            ],
            'Business Continuity' => [
                'rating' => $assessment->business_continuity_rating,
                'narrative' => $assessment->business_continuity_narrative
            ],
            'Personnel Management' => [
                'rating' => $assessment->personnel_management_rating,
                'narrative' => $assessment->personnel_management_narrative
            ],
            'Global & Technological Awareness' => [
                'rating' => $assessment->global_tech_awareness_rating,
                'narrative' => $assessment->global_tech_awareness_narrative
            ],
            'Physical Security' => [
                'rating' => $assessment->physical_security_rating,
                'narrative' => $assessment->physical_security_narrative
            ],
            'Practical Security' => [
                'rating' => $assessment->practical_security_rating,
                'narrative' => $assessment->practical_security_narrative
            ],
            'Cyber Security' => [
                'rating' => $assessment->cyber_security_rating,
                'narrative' => $assessment->cyber_security_narrative
            ],
            'Investigation & Case Management' => [
                'rating' => $assessment->investigation_case_mgmt_rating,
                'narrative' => $assessment->investigation_case_mgmt_narrative
            ],
            'Business Intelligence' => [
                'rating' => $assessment->business_intelligence_rating,
                'narrative' => $assessment->business_intelligence_narrative
            ],
            'Basic Intelligence' => [
                'rating' => $assessment->basic_intelligence_rating,
                'narrative' => $assessment->basic_intelligence_narrative
            ],
            'Mass & Conflict Management' => [
                'rating' => $assessment->mass_conflict_mgmt_rating,
                'narrative' => $assessment->mass_conflict_mgmt_narrative
            ],
            'Legal & Compliance' => [
                'rating' => $assessment->legal_compliance_rating,
                'narrative' => $assessment->legal_compliance_narrative
            ],
            'Disaster Management' => [
                'rating' => $assessment->disaster_management_rating,
                'narrative' => $assessment->disaster_management_narrative
            ],
            'SAR' => [
                'rating' => $assessment->sar_rating,
                'narrative' => $assessment->sar_narrative
            ],
            'Assessor' => [
                'rating' => $assessment->assessor_rating,
                'narrative' => $assessment->assessor_narrative
            ]
        ];
        
        return view('astra.page.assessment.detail', compact('breadcrumb1', 'breadcrumb2', 'button', 'assessment', 'competencies'));
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

    public function downloadGapAnalysisReport($id){
        $templatePath = storage_path('app/template/template_2.docx');
        if (!file_exists($templatePath)) {
            abort(404, "Template tidak ditemukan");
        }

        // Get participant data
        $peserta = Peserta::find($id);
        if (!$peserta) {
            abort(404, "Peserta tidak ditemukan");
        }

        // Get gap analysis data
        $gapAnalysis = \App\Models\GapAnalysis::where('reviewee_id', $id)->first();
        if (!$gapAnalysis) {
            // Generate gap analysis if not exists
            try {
                $gapAnalysisService = new \App\Services\GapAnalysisService();
                $gapAnalysis = $gapAnalysisService->generateGapAnalysisForReviewee($id);
            } catch (\Exception $e) {
                abort(500, "Gagal generate gap analysis: " . $e->getMessage());
            }
        }

        // Get assessment data for role breakdown (similar to detailPeserta method)
        $dataTable = FormOtherAstra::where('reviewee_id', $id)->get();
        
        // Competency field mapping
        $competencyMapping = [
            'Risk Management' => 'risk_management',
            'Business Continuity' => 'business_continuity', 
            'Personnel Management' => 'personnel_management',
            'Global & Technological Awareness' => 'global_tech_awareness',
            'Physical Security' => 'physical_security',
            'Practical Security' => 'practical_security',
            'Cyber Security' => 'cyber_security',
            'Investigation & Case Management' => 'investigation_case_mgmt',
            'Business Intelligence' => 'business_intelligence',
            'Basic Intelligence' => 'basic_intelligence',
            'Mass & Conflict Management' => 'mass_conflict_mgmt',
            'Legal & Compliance' => 'legal_compliance',
            'Disaster Management' => 'disaster_management',
            'SAR' => 'sar',
            'Assessor' => 'assessor'
        ];

        // Prepare competency data
        $competencies = [
            'Risk Management' => [
                'actual' => $gapAnalysis->risk_management_actual,
                'expected' => $gapAnalysis->risk_management_expected,
                'gap' => $gapAnalysis->risk_management_gap
            ],
            'Business Continuity' => [
                'actual' => $gapAnalysis->business_continuity_actual,
                'expected' => $gapAnalysis->business_continuity_expected,
                'gap' => $gapAnalysis->business_continuity_gap
            ],
            'Personnel Management' => [
                'actual' => $gapAnalysis->personnel_management_actual,
                'expected' => $gapAnalysis->personnel_management_expected,
                'gap' => $gapAnalysis->personnel_management_gap
            ],
            'Global & Technological Awareness' => [
                'actual' => $gapAnalysis->global_tech_awareness_actual,
                'expected' => $gapAnalysis->global_tech_awareness_expected,
                'gap' => $gapAnalysis->global_tech_awareness_gap
            ],
            'Physical Security' => [
                'actual' => $gapAnalysis->physical_security_actual,
                'expected' => $gapAnalysis->physical_security_expected,
                'gap' => $gapAnalysis->physical_security_gap
            ],
            'Practical Security' => [
                'actual' => $gapAnalysis->practical_security_actual,
                'expected' => $gapAnalysis->practical_security_expected,
                'gap' => $gapAnalysis->practical_security_gap
            ],
            'Cyber Security' => [
                'actual' => $gapAnalysis->cyber_security_actual,
                'expected' => $gapAnalysis->cyber_security_expected,
                'gap' => $gapAnalysis->cyber_security_gap
            ],
            'Investigation & Case Management' => [
                'actual' => $gapAnalysis->investigation_case_mgmt_actual,
                'expected' => $gapAnalysis->investigation_case_mgmt_expected,
                'gap' => $gapAnalysis->investigation_case_mgmt_gap
            ],
            'Business Intelligence' => [
                'actual' => $gapAnalysis->business_intelligence_actual,
                'expected' => $gapAnalysis->business_intelligence_expected,
                'gap' => $gapAnalysis->business_intelligence_gap
            ],
            'Basic Intelligence' => [
                'actual' => $gapAnalysis->basic_intelligence_actual,
                'expected' => $gapAnalysis->basic_intelligence_expected,
                'gap' => $gapAnalysis->basic_intelligence_gap
            ],
            'Mass & Conflict Management' => [
                'actual' => $gapAnalysis->mass_conflict_mgmt_actual,
                'expected' => $gapAnalysis->mass_conflict_mgmt_expected,
                'gap' => $gapAnalysis->mass_conflict_mgmt_gap
            ],
            'Legal & Compliance' => [
                'actual' => $gapAnalysis->legal_compliance_actual,
                'expected' => $gapAnalysis->legal_compliance_expected,
                'gap' => $gapAnalysis->legal_compliance_gap
            ],
            'Disaster Management' => [
                'actual' => $gapAnalysis->disaster_management_actual,
                'expected' => $gapAnalysis->disaster_management_expected,
                'gap' => $gapAnalysis->disaster_management_gap
            ],
            'SAR' => [
                'actual' => $gapAnalysis->sar_actual,
                'expected' => $gapAnalysis->sar_expected,
                'gap' => $gapAnalysis->sar_gap
            ],
            'Assessor' => [
                'actual' => $gapAnalysis->assessor_actual,
                'expected' => $gapAnalysis->assessor_expected,
                'gap' => $gapAnalysis->assessor_gap
            ]
        ];

        // NEW: Calculate individual role breakdown based on reviewer_assignments (same as detailPeserta)
        $assignments = \Illuminate\Support\Facades\DB::table('reviewer_assignments')
            ->where('reviewee_id', $id)
            ->get()
            ->keyBy('reviewer_role');
        
        $individualRoleBreakdown = [];
        
        // Process each assigned role for individual tracking
        foreach (['Atasan Langsung', 'Diri Sendiri', 'Rekan Kerja 1', 'Rekan Kerja 2', 'Bawahan Langsung 1', 'Bawahan Langsung 2'] as $role) {
            $assignment = $assignments->get($role);
            
            if ($assignment) {
                $reviewer = \App\Models\Peserta::find($assignment->reviewer_id);
                $assessment = $dataTable->where('reviewer_id', $assignment->reviewer_id)->first();
                
                $individualRoleBreakdown[$role] = [
                    'reviewer_name' => $reviewer ? $reviewer->name : 'Unknown',
                    'assessment' => $assessment,
                    'has_assessment' => $assessment !== null
                ];
            } else {
                $individualRoleBreakdown[$role] = [
                    'reviewer_name' => 'Not Assigned',
                    'assessment' => null,
                    'has_assessment' => false
                ];
            }
        }
        
        // Create merged role breakdown for display with dynamic weights
        $mergedRoleBreakdown = [
            'atasan' => [
                'assessments' => collect(),
                'base_weight' => 10,
                'actual_weight' => 10
            ],
            'diri' => [
                'assessments' => collect(),
                'base_weight' => 50,
                'actual_weight' => 50
            ],
            'rekan_kerja' => [
                'assessments' => collect(),
                'base_weight' => 20, // RK1 + RK2
                'actual_weight' => 20
            ],
            'bawahan' => [
                'assessments' => collect(),
                'base_weight' => 20, // B1 + B2
                'actual_weight' => 20
            ]
        ];
        
        // Group individual assessments into merged categories
        if (isset($individualRoleBreakdown['Atasan Langsung']['assessment'])) {
            $mergedRoleBreakdown['atasan']['assessments']->push($individualRoleBreakdown['Atasan Langsung']['assessment']);
        }
        
        if (isset($individualRoleBreakdown['Diri Sendiri']['assessment'])) {
            $mergedRoleBreakdown['diri']['assessments']->push($individualRoleBreakdown['Diri Sendiri']['assessment']);
        }
        
        foreach (['Rekan Kerja 1', 'Rekan Kerja 2'] as $role) {
            if (isset($individualRoleBreakdown[$role]['assessment'])) {
                $mergedRoleBreakdown['rekan_kerja']['assessments']->push($individualRoleBreakdown[$role]['assessment']);
            }
        }
        
        foreach (['Bawahan Langsung 1', 'Bawahan Langsung 2'] as $role) {
            if (isset($individualRoleBreakdown[$role]['assessment'])) {
                $mergedRoleBreakdown['bawahan']['assessments']->push($individualRoleBreakdown[$role]['assessment']);
            }
        }
        
        // Calculate actual weights based on individual assessments first
        $mergedRoleBreakdown['atasan']['actual_weight'] = $mergedRoleBreakdown['atasan']['assessments']->isNotEmpty() ? 10 : 0;
        $mergedRoleBreakdown['diri']['actual_weight'] = $mergedRoleBreakdown['diri']['assessments']->isNotEmpty() ? 50 : 0;
        $mergedRoleBreakdown['rekan_kerja']['actual_weight'] = $mergedRoleBreakdown['rekan_kerja']['assessments']->count() * 10; // Each assessment = 10%
        $mergedRoleBreakdown['bawahan']['actual_weight'] = $mergedRoleBreakdown['bawahan']['assessments']->count() * 10; // Each assessment = 10%
        
        // Calculate actual weights with redistribution logic
        $missingWeights = 0;
        $selfHasData = $mergedRoleBreakdown['diri']['assessments']->isNotEmpty();
        
        // Check which roles are missing and calculate redistribution
        if ($mergedRoleBreakdown['atasan']['assessments']->isEmpty()) {
            $missingWeights += $mergedRoleBreakdown['atasan']['base_weight'];
            $mergedRoleBreakdown['atasan']['actual_weight'] = 0;
        }
        
        if ($mergedRoleBreakdown['rekan_kerja']['assessments']->isEmpty()) {
            $missingWeights += $mergedRoleBreakdown['rekan_kerja']['base_weight'];
            $mergedRoleBreakdown['rekan_kerja']['actual_weight'] = 0;
        }
        
        if ($mergedRoleBreakdown['bawahan']['assessments']->isEmpty()) {
            $missingWeights += $mergedRoleBreakdown['bawahan']['base_weight'];
            $mergedRoleBreakdown['bawahan']['actual_weight'] = 0;
        }
        
        // If self has data, redistribute missing weights to self
        if ($selfHasData && $missingWeights > 0) {
            $mergedRoleBreakdown['diri']['actual_weight'] += $missingWeights;
        } elseif (!$selfHasData) {
            // If self also missing, it gets 0%
            $mergedRoleBreakdown['diri']['actual_weight'] = 0;
        }

        // Create TemplateProcessor instance
        $templateProcessor = new TemplateProcessor($templatePath);

        // Set basic variables with XML escaping for special characters
        $templateProcessor->setValue('nama_karyawan', $this->escapeXmlSpecialChars($peserta->name));
        $templateProcessor->setValue('departemen', $this->escapeXmlSpecialChars($gapAnalysis->departemen));
        $templateProcessor->setValue('fungsi', $this->escapeXmlSpecialChars($gapAnalysis->fungsi));
        
        // Set dynamic weight variables for header
        $templateProcessor->setValue('atasan_weight', $mergedRoleBreakdown['atasan']['actual_weight']);
        $templateProcessor->setValue('diri_weight', $mergedRoleBreakdown['diri']['actual_weight']);
        $templateProcessor->setValue('rekan_kerja_weight', $mergedRoleBreakdown['rekan_kerja']['actual_weight']);
        $templateProcessor->setValue('bawahan_weight', $mergedRoleBreakdown['bawahan']['actual_weight']);

        // Try dynamic table approach first, fallback to individual variables
        try {
            // Try to clone table row - this will work if template has proper table structure
            $templateProcessor->cloneRow('kompetensi', count($competencies));
            
            $rowIndex = 1;
            foreach ($competencies as $competencyName => $competencyData) {
                $templateProcessor->setValue("nomor#$rowIndex", $rowIndex);
                $templateProcessor->setValue("kompetensi#$rowIndex", $competencyName);
                
                // Get role-based ratings using merged breakdown for consistency
                $atasanRating = $mergedRoleBreakdown['atasan']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['atasan']['assessments']->avg($competencyMapping[$competencyName] . '_rating'), 1) 
                    : 'No Data';
                
                $selfRating = $mergedRoleBreakdown['diri']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['diri']['assessments']->avg($competencyMapping[$competencyName] . '_rating'), 1) 
                    : 'No Data';
                
                $rekanKerjaRating = $mergedRoleBreakdown['rekan_kerja']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['rekan_kerja']['assessments']->avg($competencyMapping[$competencyName] . '_rating'), 1) 
                    : 'No Data';
                
                $bawahanRating = $mergedRoleBreakdown['bawahan']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['bawahan']['assessments']->avg($competencyMapping[$competencyName] . '_rating'), 1) 
                    : 'No Data';
                
                $templateProcessor->setValue("atasan#$rowIndex", $atasanRating);
                $templateProcessor->setValue("self#$rowIndex", $selfRating);
                $templateProcessor->setValue("rekan_kerja#$rowIndex", $rekanKerjaRating);
                $templateProcessor->setValue("bawahan#$rowIndex", $bawahanRating);
                $templateProcessor->setValue("actual_level#$rowIndex", 
                    $competencyData['actual'] !== null ? number_format($competencyData['actual'], 2) : 'N/A');
                $templateProcessor->setValue("required_level#$rowIndex", 
                    $competencyData['expected'] !== null ? $competencyData['expected'] : 'N/A');
                
                // Calculate gap display (Actual - Expected for intuitive display)
                if ($competencyData['gap'] !== null && $competencyData['actual'] !== null && $competencyData['expected'] !== null) {
                    $trueGap = $competencyData['actual'] - $competencyData['expected'];
                    if ($trueGap > 0) {
                        $gapDisplay = '+' . number_format($trueGap, 2) . ' (Above Required)';
                    } elseif ($trueGap < 0) {
                        $gapDisplay = number_format($trueGap, 2) . ' (Below Required)';
                    } else {
                        $gapDisplay = '0.00 (Meets Required)';
                    }
                } else {
                    $gapDisplay = 'N/A';
                }
                
                $templateProcessor->setValue("gap#$rowIndex", $gapDisplay);
                $rowIndex++;
            }
        } catch (\Exception $e) {
            // Fallback: Set individual variables for template with static structure
            // Template must have variables like ${risk_management_atasan}, ${risk_management_actual}, etc.
            
            foreach ($competencies as $competencyName => $competencyData) {
                $fieldName = $competencyMapping[$competencyName];
                
                // Get role-based ratings using merged breakdown for consistency
                $atasanRating = $mergedRoleBreakdown['atasan']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['atasan']['assessments']->avg($fieldName . '_rating'), 1) 
                    : 'No Data';
                
                $selfRating = $mergedRoleBreakdown['diri']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['diri']['assessments']->avg($fieldName . '_rating'), 1) 
                    : 'No Data';
                
                $rekanKerjaRating = $mergedRoleBreakdown['rekan_kerja']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['rekan_kerja']['assessments']->avg($fieldName . '_rating'), 1) 
                    : 'No Data';
                
                $bawahanRating = $mergedRoleBreakdown['bawahan']['assessments']->isNotEmpty()
                    ? number_format($mergedRoleBreakdown['bawahan']['assessments']->avg($fieldName . '_rating'), 1) 
                    : 'No Data';
                
                // Calculate gap display
                if ($competencyData['gap'] !== null && $competencyData['actual'] !== null && $competencyData['expected'] !== null) {
                    $trueGap = $competencyData['actual'] - $competencyData['expected'];
                    if ($trueGap > 0) {
                        $gapDisplay = '+' . number_format($trueGap, 2) . ' (Above Required)';
                    } elseif ($trueGap < 0) {
                        $gapDisplay = number_format($trueGap, 2) . ' (Below Required)';
                    } else {
                        $gapDisplay = '0.00 (Meets Required)';
                    }
                } else {
                    $gapDisplay = 'N/A';
                }
                
                // Set individual variables for this competency
                $templateProcessor->setValue($fieldName . '_atasan', $atasanRating);
                $templateProcessor->setValue($fieldName . '_self', $selfRating);
                $templateProcessor->setValue($fieldName . '_rekan_kerja', $rekanKerjaRating);
                $templateProcessor->setValue($fieldName . '_bawahan', $bawahanRating);
                $templateProcessor->setValue($fieldName . '_actual', 
                    $competencyData['actual'] !== null ? number_format($competencyData['actual'], 2) : 'N/A');
                $templateProcessor->setValue($fieldName . '_required', 
                    $competencyData['expected'] !== null ? $competencyData['expected'] : 'N/A');
                $templateProcessor->setValue($fieldName . '_gap', $gapDisplay);
            }
        }

        // Calculate recommendation percentage using RecommendationService for consistency
        $recommendationService = new \App\Services\RecommendationService();
        $recommendation = $recommendationService->calculateRecommendation($gapAnalysis);
        $percentage = $recommendation['percentage'];

        // Set checkbox variables for conclusion section
        $templateProcessor->setValue('kesimpulan_100_checked', $percentage == 100 ? '☑' : '☐');
        $templateProcessor->setValue('kesimpulan_75_checked', ($percentage >= 75 && $percentage < 100) ? '☑' : '☐');
        $templateProcessor->setValue('kesimpulan_37_checked', ($percentage >= 37.5 && $percentage < 75) ? '☑' : '☐');
        $templateProcessor->setValue('kesimpulan_0_checked', $percentage < 37.5 ? '☑' : '☐');

        // Calculate top 3 and bottom 3 competencies for template
        $competencyBreakdown = $recommendationService->getCompetencyBreakdown($gapAnalysis);
        $competencyRankings = $this->calculateCompetencyRankings($competencyBreakdown);
        
        // Load competency matrix from JSON
        $matrixJsonPath = storage_path('app/competencies/matrix_others.json');
        $competencyMatrix = [];
        if (file_exists($matrixJsonPath)) {
            $competencyMatrix = json_decode(file_get_contents($matrixJsonPath), true);
        }

        // Set Top 3 variables (best performing competencies) with XML escaping and level descriptions
        $templateProcessor->setValue('top1_name', isset($competencyRankings['top3'][0]) ? $this->escapeXmlSpecialChars($competencyRankings['top3'][0]['name']) : 'N/A');
        $templateProcessor->setValue('top1_gap', isset($competencyRankings['top3'][0]) ? '+' . number_format($competencyRankings['top3'][0]['gap'], 2) : 'N/A');
        $templateProcessor->setValue('top1_score', isset($competencyRankings['top3'][0]) ? number_format($competencyRankings['top3'][0]['actual'], 2) . '/' . $competencyRankings['top3'][0]['expected'] : 'N/A');
        $templateProcessor->setValue('top1_level_desc', isset($competencyRankings['top3'][0]) ? $this->getCompetencyLevelDescription($competencyRankings['top3'][0], $competencyMatrix) : 'N/A');
        
        $templateProcessor->setValue('top2_name', isset($competencyRankings['top3'][1]) ? $this->escapeXmlSpecialChars($competencyRankings['top3'][1]['name']) : 'N/A');
        $templateProcessor->setValue('top2_gap', isset($competencyRankings['top3'][1]) ? '+' . number_format($competencyRankings['top3'][1]['gap'], 2) : 'N/A');
        $templateProcessor->setValue('top2_score', isset($competencyRankings['top3'][1]) ? number_format($competencyRankings['top3'][1]['actual'], 2) . '/' . $competencyRankings['top3'][1]['expected'] : 'N/A');
        $templateProcessor->setValue('top2_level_desc', isset($competencyRankings['top3'][1]) ? $this->getCompetencyLevelDescription($competencyRankings['top3'][1], $competencyMatrix) : 'N/A');
        
        $templateProcessor->setValue('top3_name', isset($competencyRankings['top3'][2]) ? $this->escapeXmlSpecialChars($competencyRankings['top3'][2]['name']) : 'N/A');
        $templateProcessor->setValue('top3_gap', isset($competencyRankings['top3'][2]) ? '+' . number_format($competencyRankings['top3'][2]['gap'], 2) : 'N/A');
        $templateProcessor->setValue('top3_score', isset($competencyRankings['top3'][2]) ? number_format($competencyRankings['top3'][2]['actual'], 2) . '/' . $competencyRankings['top3'][2]['expected'] : 'N/A');
        $templateProcessor->setValue('top3_level_desc', isset($competencyRankings['top3'][2]) ? $this->getCompetencyLevelDescription($competencyRankings['top3'][2], $competencyMatrix) : 'N/A');
        
        // Set Bottom 3 variables (competencies needing most development) with XML escaping and level descriptions
        $templateProcessor->setValue('bottom1_name', isset($competencyRankings['bottom3'][0]) ? $this->escapeXmlSpecialChars($competencyRankings['bottom3'][0]['name']) : 'N/A');
        $templateProcessor->setValue('bottom1_gap', isset($competencyRankings['bottom3'][0]) ? number_format($competencyRankings['bottom3'][0]['gap'], 2) : 'N/A');
        $templateProcessor->setValue('bottom1_score', isset($competencyRankings['bottom3'][0]) ? number_format($competencyRankings['bottom3'][0]['actual'], 2) . '/' . $competencyRankings['bottom3'][0]['expected'] : 'N/A');
        $templateProcessor->setValue('bottom1_level_desc', isset($competencyRankings['bottom3'][0]) ? $this->getCompetencyLevelDescription($competencyRankings['bottom3'][0], $competencyMatrix) : 'N/A');
        
        $templateProcessor->setValue('bottom2_name', isset($competencyRankings['bottom3'][1]) ? $this->escapeXmlSpecialChars($competencyRankings['bottom3'][1]['name']) : 'N/A');
        $templateProcessor->setValue('bottom2_gap', isset($competencyRankings['bottom3'][1]) ? number_format($competencyRankings['bottom3'][1]['gap'], 2) : 'N/A');
        $templateProcessor->setValue('bottom2_score', isset($competencyRankings['bottom3'][1]) ? number_format($competencyRankings['bottom3'][1]['actual'], 2) . '/' . $competencyRankings['bottom3'][1]['expected'] : 'N/A');
        $templateProcessor->setValue('bottom2_level_desc', isset($competencyRankings['bottom3'][1]) ? $this->getCompetencyLevelDescription($competencyRankings['bottom3'][1], $competencyMatrix) : 'N/A');
        
        $templateProcessor->setValue('bottom3_name', isset($competencyRankings['bottom3'][2]) ? $this->escapeXmlSpecialChars($competencyRankings['bottom3'][2]['name']) : 'N/A');
        $templateProcessor->setValue('bottom3_gap', isset($competencyRankings['bottom3'][2]) ? number_format($competencyRankings['bottom3'][2]['gap'], 2) : 'N/A');
        $templateProcessor->setValue('bottom3_score', isset($competencyRankings['bottom3'][2]) ? number_format($competencyRankings['bottom3'][2]['actual'], 2) . '/' . $competencyRankings['bottom3'][2]['expected'] : 'N/A');
        $templateProcessor->setValue('bottom3_level_desc', isset($competencyRankings['bottom3'][2]) ? $this->getCompetencyLevelDescription($competencyRankings['bottom3'][2], $competencyMatrix) : 'N/A');

        // Load development matrix from JSON
        $developmentJsonPath = storage_path('app/competencies/matrix_pengembangan.json');
        $developmentMatrix = [];
        if (file_exists($developmentJsonPath)) {
            $developmentMatrix = json_decode(file_get_contents($developmentJsonPath), true);
        }

        // Set Bottom 3 development recommendations
        $templateProcessor->setValue('bottom1_training', isset($competencyRankings['bottom3'][0]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][0], $developmentMatrix, 'training') : 'N/A');
        $templateProcessor->setValue('bottom1_coaching', isset($competencyRankings['bottom3'][0]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][0], $developmentMatrix, 'coaching_mentoring') : 'N/A');
        $templateProcessor->setValue('bottom1_assignment', isset($competencyRankings['bottom3'][0]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][0], $developmentMatrix, 'special_assignment') : 'N/A');
        $templateProcessor->setValue('bottom1_feedback', isset($competencyRankings['bottom3'][0]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][0], $developmentMatrix, 'feedback') : 'N/A');
        $templateProcessor->setValue('bottom1_self_dev', isset($competencyRankings['bottom3'][0]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][0], $developmentMatrix, 'self_development') : 'N/A');

        $templateProcessor->setValue('bottom2_training', isset($competencyRankings['bottom3'][1]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][1], $developmentMatrix, 'training') : 'N/A');
        $templateProcessor->setValue('bottom2_coaching', isset($competencyRankings['bottom3'][1]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][1], $developmentMatrix, 'coaching_mentoring') : 'N/A');
        $templateProcessor->setValue('bottom2_assignment', isset($competencyRankings['bottom3'][1]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][1], $developmentMatrix, 'special_assignment') : 'N/A');
        $templateProcessor->setValue('bottom2_feedback', isset($competencyRankings['bottom3'][1]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][1], $developmentMatrix, 'feedback') : 'N/A');
        $templateProcessor->setValue('bottom2_self_dev', isset($competencyRankings['bottom3'][1]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][1], $developmentMatrix, 'self_development') : 'N/A');

        $templateProcessor->setValue('bottom3_training', isset($competencyRankings['bottom3'][2]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][2], $developmentMatrix, 'training') : 'N/A');
        $templateProcessor->setValue('bottom3_coaching', isset($competencyRankings['bottom3'][2]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][2], $developmentMatrix, 'coaching_mentoring') : 'N/A');
        $templateProcessor->setValue('bottom3_assignment', isset($competencyRankings['bottom3'][2]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][2], $developmentMatrix, 'special_assignment') : 'N/A');
        $templateProcessor->setValue('bottom3_feedback', isset($competencyRankings['bottom3'][2]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][2], $developmentMatrix, 'feedback') : 'N/A');
        $templateProcessor->setValue('bottom3_self_dev', isset($competencyRankings['bottom3'][2]) ? $this->getCompetencyDevelopmentRecommendation($competencyRankings['bottom3'][2], $developmentMatrix, 'self_development') : 'N/A');

        // Generate safe filename
        $safeFilename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $peserta->name);
        $outputFile = storage_path('app/gap_analysis_report_' . $safeFilename . '_' . date('Y-m-d') . '.docx');
        
        // Save the document
        $templateProcessor->saveAs($outputFile);

        // Return download response
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

    /**
     * Escape XML special characters for Word template processing
     */
    private function escapeXmlSpecialChars($text)
    {
        if ($text === null) {
            return '';
        }
        
        // Escape XML special characters
        $text = str_replace('&', '&amp;', $text);
        $text = str_replace('<', '&lt;', $text);
        $text = str_replace('>', '&gt;', $text);
        $text = str_replace('"', '&quot;', $text);
        $text = str_replace("'", '&apos;', $text);
        
        return $text;
    }

    /**
     * Calculate top 3 and bottom 3 competencies by gap
     */
    private function calculateCompetencyRankings($competencyBreakdown)
    {
        if (empty($competencyBreakdown)) {
            return [
                'top3' => [],
                'bottom3' => []
            ];
        }

        try {
            // Filter out competencies with null gaps and sort by gap (descending for top, ascending for bottom)
            $validCompetencies = collect($competencyBreakdown)
                ->filter(function($competency) {
                    return isset($competency['gap']) && 
                           $competency['gap'] !== null && 
                           is_numeric($competency['gap']) &&
                           isset($competency['name']) && 
                           !empty($competency['name']);
                });

            // Top 3: Highest gaps (best performance above requirement)
            $top3 = $validCompetencies
                ->sortByDesc('gap')
                ->take(3)
                ->values()
                ->toArray();

            // Bottom 3: Lowest gaps (worst performance below requirement)
            $bottom3 = $validCompetencies
                ->sortBy('gap')
                ->take(3)
                ->values()
                ->toArray();

            return [
                'top3' => $top3,
                'bottom3' => $bottom3
            ];
        } catch (\Exception $e) {
            // Return empty arrays if there's any error
            return [
                'top3' => [],
                'bottom3' => []
            ];
        }
    }

    /**
     * Get competency level description from JSON matrix based on actual score
     */
    private function getCompetencyLevelDescription($competencyData, $competencyMatrix)
    {
        if (!isset($competencyData['actual']) || !isset($competencyData['name']) || empty($competencyMatrix)) {
            return 'N/A';
        }

        // Round actual score to determine level (1.4 -> 1, 1.5 -> 2)
        $actualScore = floatval($competencyData['actual']);
        $level = round($actualScore);
        
        // Ensure level is between 1-4
        $level = max(1, min(4, $level));

        // Find competency in matrix by name
        foreach ($competencyMatrix as $competency) {
            if (strtolower(trim($competency['name'])) === strtolower(trim($competencyData['name']))) {
                // Find the level description
                foreach ($competency['levels'] as $levelData) {
                    if ($levelData['level'] == $level) {
                        return $this->escapeXmlSpecialChars($levelData['description']);
                    }
                }
                break;
            }
        }

        return 'N/A';
    }

    /**
     * Get competency development recommendation from JSON matrix
     */
    private function getCompetencyDevelopmentRecommendation($competencyData, $developmentMatrix, $method)
    {
        if (!isset($competencyData['name']) || empty($developmentMatrix)) {
            return 'N/A';
        }

        // Find competency in development matrix by name
        foreach ($developmentMatrix as $competency) {
            if (strtolower(trim($competency['name'])) === strtolower(trim($competencyData['name']))) {
                // Return the requested development method
                if (isset($competency['development_methods'][$method])) {
                    return $this->escapeXmlSpecialChars($competency['development_methods'][$method]);
                }
                break;
            }
        }

        return 'N/A';
    }
}