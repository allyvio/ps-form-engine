@extends('astra.layouts._master')

@push('styles')
<!-- ApexCharts CSS - hanya untuk halaman ini -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.css">
@endpush

@push('scripts')
<!-- ApexCharts JS - hanya untuk halaman ini -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>
@endpush

@section('content')
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            @include('dashboard.layouts._breadcrumb')
            <!-- Card stats -->
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-3 order-xl-2">
            <div class="card card-profile">
                <img src="{{asset('dashboard/img/theme/img-1-1000x600.jpg')}}" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="{{asset('dashboard/img/theme/users.jpg')}}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading">{{ isset($roleBreakdown['atasan']['count']) ? $roleBreakdown['atasan']['count'] : 0 }}</span>
                                    <span class="description">Atasan</span>
                                </div>
                                <div>
                                    <span class="heading">{{ isset($roleBreakdown['self']['count']) ? $roleBreakdown['self']['count'] : 0 }}</span>
                                    <span class="description">Self</span>
                                </div>
                                <div>
                                    <span class="heading">{{ isset($roleBreakdown['rekan_kerja']['count']) ? $roleBreakdown['rekan_kerja']['count'] : 0 }}</span>
                                    <span class="description">Rekan Kerja</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 class="h3">
                            {{$detailPeserta->name}}<span class="font-weight-light"></span>
                        </h5>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{$detailPeserta->email}}
                        </div>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>{{ isset($gapAnalysis) ? $gapAnalysis->fungsi . ' - ' . $gapAnalysis->departemen : $detailPeserta->jabatan . ' - ' . $detailPeserta->departemen }}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>Astra International
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Assessment Summary Card -->
            <div class="card shadow mt-4">
                <div class="card-header bg-gradient-primary">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="h3 mb-0 text-white">Assessment Summary</h6>
                            <p class="text-white-50 mb-0 small">Overview penilaian kompetensi</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-sm font-weight-bold text-dark">Total Penilai</span>
                                <span class="h4 font-weight-bold text-primary mb-0">{{ $countPenilai ?? 0 }}</span>
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar bg-primary" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    
                    @if(isset($recommendation))
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm font-weight-bold text-dark">Pemenuhan Kompetensi</span>
                                <span class="h4 font-weight-bold text-{{ $recommendationColor }} mb-0">{{ $recommendation['percentage'] }}%</span>
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar bg-{{ $recommendationColor }}" style="width: {{ $recommendation['percentage'] }}%"></div>
                            </div>
                            <small class="text-muted">{{ $recommendation['competencies_met'] }}/{{ $recommendation['total_required'] }} kompetensi terpenuhi</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="card shadow mt-4">
                <div class="card-header bg-gradient-dark">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="h3 mb-0 text-white">Quick Actions</h6>
                            <p class="text-white mb-0 small">Aksi cepat untuk laporan</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bolt text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @if(isset($gapAnalysis) && $gapAnalysis)
                            <a href="{{ url('/download-gap-report/' . $detailPeserta->id) }}" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="ni ni-chart-bar-32"></i>
                                        </div>
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-sm mb-0">Gap Analysis Report</h6>
                                                <p class="text-sm text-muted mb-0">Download laporan lengkap</p>
                                            </div>
                                            <i class="fas fa-download text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="list-group-item border-0 px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-secondary text-white rounded-circle shadow">
                                            <i class="ni ni-fat-remove"></i>
                                        </div>
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-sm mb-0 text-muted">Gap Analysis Report</h6>
                                                <p class="text-sm text-muted mb-0">Tidak tersedia - Belum ada data assessment</p>
                                            </div>
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Assessment Status Card -->
            @if(isset($roleBreakdown))
            <div class="card shadow mt-4">
                <div class="card-header bg-gradient-info">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="h3 mb-0 text-white">Assessment Status</h6>
                            <p class="text-white-50 mb-0 small">Status penilaian per kategori</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block py-2">
                            <span class="timeline-step {{ isset($roleBreakdown['atasan']['count']) && $roleBreakdown['atasan']['count'] > 0 ? 'bg-success' : 'bg-secondary' }}">
                                <i class="ni ni-single-02"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-sm font-weight-bold mb-0">Atasan</h6>
                                <p class="text-sm text-muted mb-0">{{ isset($roleBreakdown['atasan']['count']) ? $roleBreakdown['atasan']['count'] : 0 }} penilaian</p>
                            </div>
                        </div>
                        <div class="timeline-block py-2">
                            <span class="timeline-step {{ isset($roleBreakdown['self']['count']) && $roleBreakdown['self']['count'] > 0 ? 'bg-success' : 'bg-secondary' }}">
                                <i class="ni ni-circle-08"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-sm font-weight-bold mb-0">Self Assessment</h6>
                                <p class="text-sm text-muted mb-0">{{ isset($roleBreakdown['self']['count']) ? $roleBreakdown['self']['count'] : 0 }} penilaian</p>
                            </div>
                        </div>
                        <div class="timeline-block py-2">
                            <span class="timeline-step {{ isset($roleBreakdown['rekan_kerja']['count']) && $roleBreakdown['rekan_kerja']['count'] > 0 ? 'bg-success' : 'bg-secondary' }}">
                                <i class="ni ni-bullet-list-67"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-sm font-weight-bold mb-0">Rekan Kerja</h6>
                                <p class="text-sm text-muted mb-0">{{ isset($roleBreakdown['rekan_kerja']['count']) ? $roleBreakdown['rekan_kerja']['count'] : 0 }} penilaian</p>
                            </div>
                        </div>
                        <div class="timeline-block py-2">
                            <span class="timeline-step {{ isset($roleBreakdown['bawahan']['count']) && $roleBreakdown['bawahan']['count'] > 0 ? 'bg-success' : 'bg-secondary' }}">
                                <i class="ni ni-support-16"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-sm font-weight-bold mb-0">Bawahan</h6>
                                <p class="text-sm text-muted mb-0">{{ isset($roleBreakdown['bawahan']['count']) ? $roleBreakdown['bawahan']['count'] : 0 }} penilaian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-xl-9 order-xl-1">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card bg-gradient-info border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0 text-white">Actual Level</h5>
                                    <span class="h2 font-weight-bold mb-0 text-white">{{ $overallActualLevel ?? 'N/A' }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                        <i class="ni ni-active-40"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> {{number_format(rand(1,3),1)}}%</span>
                                <span class="text-nowrap text-light">Since last test</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card bg-gradient-danger border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0 text-white">Overall Gap</h5>
                                    <span class="h2 font-weight-bold mb-0 text-white">{{ isset($gapAnalysis) ? $gapAnalysis->overall_gap_score : 'N/A' }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                        <i class="ni ni-spaceship"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> {{number_format(rand(1,3),1)}}%</span>
                                <span class="text-nowrap text-light">Since last test</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts Section -->
            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mb-0">Gap Analysis Overview</h5>
                            <p class="text-muted mb-0">Competency gaps vs expected levels</p>
                        </div>
                        <div class="card-body">
                            <canvas id="gapChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mb-0">Assessment Breakdown</h5>
                            <p class="text-muted mb-0">Sources of assessment data</p>
                        </div>
                        <div class="card-body">
                            <canvas id="assessmentBreakdownChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Third Chart - Gap Distribution -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mb-0">Gap Distribution</h5>
                            <p class="text-muted mb-0">Performance gaps across all competencies</p>
                        </div>
                        <div class="card-body">
                            <div id="gapDistributionChart" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recommendation Section -->
            @if(isset($recommendation))
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card border-{{ $recommendationColor }}">
                        <div class="card-header bg-{{ $recommendationColor }} text-white">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="h3 mb-0">Rekomendasi</h5>
                                    <p class="mb-0">Berdasarkan pemenuhan {{ $recommendation['total_required'] }} kompetensi wajib</p>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center">
                                        <span class="h1 font-weight-bold mb-0 mr-2">{{ $recommendation['percentage'] }}%</span>
                                        @if($recommendation['percentage'] == 100)
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        @elseif($recommendation['percentage'] >= 75)
                                            <i class="fas fa-thumbs-up fa-2x"></i>
                                        @elseif($recommendation['percentage'] >= 37.5)
                                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                                        @else
                                            <i class="fas fa-times-circle fa-2x"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="text-{{ $recommendationColor }} font-weight-bold">{{ $recommendation['category'] }}</h6>
                                    <p class="text-muted mb-0">{{ $recommendation['description'] }}</p>
                                    
                                    @if($recommendation['competencies_need_development'] > 0)
                                        <div class="mt-3">
                                            <h6 class="font-weight-bold">Kompetensi yang Perlu Dikembangkan:</h6>
                                            <div class="row">
                                                @foreach($competencyBreakdown as $competency)
                                                    @if(!$competency['is_met'])
                                                        <div class="col-md-6 mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge badge-danger mr-2">
                                                                    {{ $competency['actual'] ? number_format($competency['actual'], 1) : 'N/A' }}/{{ $competency['expected'] }}
                                                                </span>
                                                                <small class="text-muted">{{ $competency['name'] }}</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <span class="h4 font-weight-bold text-{{ $recommendationColor }}">{{ $recommendation['competencies_met'] }}</span>
                                            <span class="text-muted">/ {{ $recommendation['total_required'] }}</span>
                                        </div>
                                        <p class="text-muted mb-0">Kompetensi Terpenuhi</p>
                                        
                                        <!-- Progress bar -->
                                        <div class="progress mt-3" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $recommendationColor }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $recommendation['percentage'] }}%" 
                                                 aria-valuenow="{{ $recommendation['percentage'] }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Competency Rankings Section -->
                            @if(isset($competencyRankings) && (!empty($competencyRankings['top3']) || !empty($competencyRankings['bottom3'])))
                            <div class="row mt-3">
                                <!-- Top 3 Competencies -->
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <div class="card border-success h-100">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0"><i class="fas fa-trophy mr-2"></i>Top 3 Kompetensi Terbaik</h6>
                                        </div>
                                        <div class="card-body">
                                            @if(!empty($competencyRankings['top3']))
                                                @foreach($competencyRankings['top3'] as $index => $competency)
                                                <div class="d-flex align-items-center mb-2 {{ $index < 2 ? 'border-bottom pb-2' : '' }}">
                                                    <span class="badge badge-success mr-3" style="min-width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 14px;">{{ $index + 1 }}</span>
                                                    <div class="flex-grow-1">
                                                        <div class="font-weight-bold text-dark">{{ $competency['name'] }}</div>
                                                        <small class="text-muted d-block mt-1">
                                                            Gap: <span class="{{ $competency['gap'] >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">{{ $competency['gap'] >= 0 ? '+' . number_format($competency['gap'], 2) : number_format($competency['gap'], 2) }}</span>
                                                            <span class="mx-1">•</span>
                                                            Level: <span class="text-dark font-weight-bold">{{ number_format($competency['actual'], 2) }}/{{ $competency['expected'] }}</span>
                                                        </small>
                                                    </div>
                                                    <div class="text-right">
                                                        <i class="fas fa-medal text-warning" style="font-size: 20px;"></i>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-info-circle text-muted mb-2" style="font-size: 48px;"></i>
                                                    <p class="text-muted mb-0">Tidak ada kompetensi yang melebihi requirement</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bottom 3 Competencies -->
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <div class="card border-danger h-100">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0"><i class="fas fa-exclamation-triangle mr-2"></i>Top 3 Kompetensi Perlu Pengembangan</h6>
                                        </div>
                                        <div class="card-body">
                                            @if(!empty($competencyRankings['bottom3']))
                                                @foreach($competencyRankings['bottom3'] as $index => $competency)
                                                <div class="d-flex align-items-center mb-2 {{ $index < 2 ? 'border-bottom pb-2' : '' }}">
                                                    <span class="badge badge-danger mr-3" style="min-width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 14px;">{{ $index + 1 }}</span>
                                                    <div class="flex-grow-1">
                                                        <div class="font-weight-bold text-dark">{{ $competency['name'] }}</div>
                                                        <small class="text-muted d-block mt-1">
                                                            Gap: <span class="text-danger font-weight-bold">{{ number_format($competency['gap'], 2) }}</span>
                                                            <span class="mx-1">•</span>
                                                            Level: <span class="text-dark font-weight-bold">{{ number_format($competency['actual'], 2) }}/{{ $competency['expected'] }}</span>
                                                        </small>
                                                    </div>
                                                    <div class="text-right">
                                                        <i class="fas fa-chart-line text-warning" style="font-size: 20px;"></i>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-check-circle text-success mb-2" style="font-size: 48px;"></i>
                                                    <p class="text-muted mb-0">Semua kompetensi memenuhi requirement</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Kesimpulan Section -->
                            <div class="card-footer bg-light">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="font-weight-bold mb-3">Kesimpulan</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" 
                                                           {{ $recommendation['percentage'] == 100 ? 'checked' : '' }} 
                                                           disabled>
                                                    <label class="form-check-label {{ $recommendation['percentage'] == 100 ? 'font-weight-bold text-success' : 'text-muted' }}">
                                                        Memenuhi kriteria jabatan saat ini
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" 
                                                           {{ ($recommendation['percentage'] >= 75 && $recommendation['percentage'] < 100) ? 'checked' : '' }} 
                                                           disabled>
                                                    <label class="form-check-label {{ ($recommendation['percentage'] >= 75 && $recommendation['percentage'] < 100) ? 'font-weight-bold text-info' : 'text-muted' }}">
                                                        Cukup memenuhi kriteria jabatan saat ini
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" 
                                                           {{ ($recommendation['percentage'] >= 37.5 && $recommendation['percentage'] < 75) ? 'checked' : '' }} 
                                                           disabled>
                                                    <label class="form-check-label {{ ($recommendation['percentage'] >= 37.5 && $recommendation['percentage'] < 75) ? 'font-weight-bold text-warning' : 'text-muted' }}">
                                                        Kurang memenuhi kriteria jabatan saat ini
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" 
                                                           {{ $recommendation['percentage'] < 37.5 ? 'checked' : '' }} 
                                                           disabled>
                                                    <label class="form-check-label {{ $recommendation['percentage'] < 37.5 ? 'font-weight-bold text-danger' : 'text-muted' }}">
                                                        Belum memenuhi kriteria jabatan saat ini
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- Ringkasan Hasil Asesmen Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="mb-0">Ringkasan Hasil Asesmen</h3>
                </div>
                <div class="card-body">
                    @php
                        // Load competency matrix and development matrix for descriptions
                        $matrixJsonPath = storage_path('app/competencies/matrix_others.json');
                        $competencyMatrix = [];
                        if (file_exists($matrixJsonPath)) {
                            $competencyMatrix = json_decode(file_get_contents($matrixJsonPath), true);
                        }
                        
                        $developmentJsonPath = storage_path('app/competencies/matrix_pengembangan.json');
                        $developmentMatrix = [];
                        if (file_exists($developmentJsonPath)) {
                            $developmentMatrix = json_decode(file_get_contents($developmentJsonPath), true);
                        }
                        
                        // Helper function to get competency level description
                        function getCompetencyDescription($competencyData, $competencyMatrix) {
                            if (!isset($competencyData['actual']) || !isset($competencyData['name']) || empty($competencyMatrix)) {
                                return 'N/A';
                            }
                            $actualScore = floatval($competencyData['actual']);
                            $level = round($actualScore);
                            $level = max(1, min(4, $level));
                            foreach ($competencyMatrix as $competency) {
                                if (strtolower(trim($competency['name'])) === strtolower(trim($competencyData['name']))) {
                                    foreach ($competency['levels'] as $levelData) {
                                        if ($levelData['level'] == $level) {
                                            return $levelData['description'];
                                        }
                                    }
                                    break;
                                }
                            }
                            return 'N/A';
                        }
                        
                        // Helper function to get development recommendations
                        function getDevelopmentRecommendation($competencyData, $developmentMatrix, $method) {
                            if (!isset($competencyData['name']) || empty($developmentMatrix)) {
                                return 'N/A';
                            }
                            foreach ($developmentMatrix as $competency) {
                                if (strtolower(trim($competency['name'])) === strtolower(trim($competencyData['name']))) {
                                    if (isset($competency['development_methods'][$method])) {
                                        return $competency['development_methods'][$method];
                                    }
                                    break;
                                }
                            }
                            return 'N/A';
                        }
                    @endphp
                    
                    <!-- Employee Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6 class="text-primary mb-2">Informasi Karyawan</h6>
                            <p class="mb-1"><strong>{{ $detailPeserta->name }}</strong></p>
                            <p class="text-muted mb-0">{{ $gapAnalysis ? $gapAnalysis->departemen : 'N/A' }} - {{ $gapAnalysis ? $gapAnalysis->fungsi : 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-primary mb-2">Tingkat Kesesuaian</h6>
                            <div class="d-flex align-items-center">
                                <span class="h4 text-{{ $recommendationColor }} mb-0 mr-2">{{ $recommendation['percentage'] }}%</span>
                                <span class="text-muted">{{ $recommendation['category'] }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-primary mb-2">Kompetensi</h6>
                            <p class="mb-0">{{ $recommendation['competencies_met'] }} Terpenuhi / {{ $recommendation['competencies_need_development'] }} Perlu Pengembangan</p>
                        </div>
                    </div>
                    
                    <!-- Kekuatan Section -->
                    @if(isset($competencyRankings) && !empty($competencyRankings['top3']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-success mb-3"><i class="fas fa-trophy mr-2"></i>Kekuatan</h5>
                            <div class="bg-light p-4 rounded">
                                <p class="text-justify">
                                    Berdasarkan hasil asesmen kompetensi, <strong>{{ $detailPeserta->name }}</strong> menunjukkan kekuatan yang signifikan dalam tiga kompetensi utama, yaitu: 
                                    @foreach($competencyRankings['top3'] as $index => $competency)
                                        <strong>{{ $competency['name'] }}</strong>{{ $index < 2 ? ', ' : ($index == 1 ? ', dan ' : '. ') }}
                                    @endforeach
                                    Kompetensi-kompetensi ini terlihat menonjol dari penilaian 360 derajat yang melibatkan atasan, rekan kerja, dan bawahan, serta didukung oleh hasil uji kompetensi tertulis.
                                    
                                    @foreach($competencyRankings['top3'] as $index => $competency)
                                        {{ $competency['name'] }} menunjukkan kemampuan {{ getCompetencyDescription($competency, $competencyMatrix) }}{{ $index < 2 ? ', ' : '. ' }}
                                    @endforeach
                                    
                                    Kekuatan-kekuatan ini merupakan aset berharga bagi {{ $detailPeserta->name }} dalam menjalankan tugas dan tanggung jawabnya.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Peluang Section -->
                    @if(isset($competencyRankings) && !empty($competencyRankings['bottom3']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-warning mb-3"><i class="fas fa-chart-line mr-2"></i>Peluang</h5>
                            <div class="bg-light p-4 rounded">
                                <p class="text-justify">
                                    Meskipun memiliki kekuatan yang menonjol, asesmen juga mengidentifikasi beberapa peluang pengembangan untuk <strong>{{ $detailPeserta->name }}</strong>. 
                                    Tiga kompetensi yang perlu menjadi fokus pengembangan adalah: 
                                    @foreach($competencyRankings['bottom3'] as $index => $competency)
                                        <strong>{{ $competency['name'] }}</strong>{{ $index < 2 ? ', ' : ($index == 1 ? ', dan ' : '. ') }}
                                    @endforeach
                                    
                                    @foreach($competencyRankings['bottom3'] as $index => $competency)
                                        @if($competency['gap'] < 0)
                                            {{ $competency['name'] }} dinilai masih berada di bawah level kompetensi yang diharapkan untuk jenjang jabatan saat ini, terutama dalam hal {{ getCompetencyDescription($competency, $competencyMatrix) }}.
                                        @else
                                            {{ $competency['name'] }} telah mencapai level kompetensi yang diharapkan, namun masih terdapat ruang untuk peningkatan dalam {{ getCompetencyDescription($competency, $competencyMatrix) }}.
                                        @endif
                                    @endforeach
                                    
                                    Pengembangan kompetensi-kompetensi ini akan membantu {{ $detailPeserta->name }} untuk mencapai kinerja yang lebih optimal dan memenuhi tuntutan jabatan.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Saran Pengembangan Section -->
                    @if(isset($competencyRankings) && !empty($competencyRankings['bottom3']))
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-info mb-3"><i class="fas fa-lightbulb mr-2"></i>Saran Pengembangan</h5>
                            <div class="bg-light p-4 rounded">
                                <p class="text-justify mb-3">
                                    Untuk mendukung pengembangan kompetensi <strong>{{ $detailPeserta->name }}</strong>, beberapa saran pengembangan berikut dapat dipertimbangkan:
                                </p>
                                
                                <div class="row">
                                    <!-- Training -->
                                    <div class="col-md-6 mb-4">
                                        <h6 class="text-primary"><i class="fas fa-graduation-cap mr-2"></i>Pelatihan dan Pengembangan</h6>
                                        <p class="small mb-2">Mengikuti pelatihan atau workshop relevan dengan kompetensi yang perlu dikembangkan:</p>
                                        <ol class="small">
                                            @foreach($competencyRankings['bottom3'] as $index => $competency)
                                                <li>{{ getDevelopmentRecommendation($competency, $developmentMatrix, 'training') }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                    
                                    <!-- Mentoring -->
                                    <div class="col-md-6 mb-4">
                                        <h6 class="text-success"><i class="fas fa-user-tie mr-2"></i>Mentoring dan Coaching</h6>
                                        <p class="small mb-2">Mendapatkan bimbingan dari mentor atau coach yang berpengalaman:</p>
                                        <ol class="small">
                                            @foreach($competencyRankings['bottom3'] as $index => $competency)
                                                <li>{{ getDevelopmentRecommendation($competency, $developmentMatrix, 'coaching_mentoring') }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                    
                                    <!-- Special Assignment -->
                                    <div class="col-md-6 mb-4">
                                        <h6 class="text-warning"><i class="fas fa-tasks mr-2"></i>Penugasan Khusus</h6>
                                        <p class="small mb-2">Diberikan penugasan khusus yang menantang:</p>
                                        <ol class="small">
                                            @foreach($competencyRankings['bottom3'] as $index => $competency)
                                                <li>{{ getDevelopmentRecommendation($competency, $developmentMatrix, 'special_assignment') }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                    
                                    <!-- Self Development -->
                                    <div class="col-md-6 mb-4">
                                        <h6 class="text-info"><i class="fas fa-book mr-2"></i>Pengembangan Mandiri</h6>
                                        <p class="small mb-2">Mendorong pengembangan mandiri melalui pembelajaran:</p>
                                        <ol class="small">
                                            @foreach($competencyRankings['bottom3'] as $index => $competency)
                                                <li>{{ getDevelopmentRecommendation($competency, $developmentMatrix, 'self_development') }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Tanggapan Survei dilihat berdasarkan Gap Kompetensi</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">No.</th>
                                <th scope="col" class="sort" data-sort="budget">Kompetensi</th>
                                <th scope="col" class="sort" data-sort="status">Atasan({{ $mergedRoleBreakdown['atasan']['actual_weight'] }}%)</th>
                                <th scope="col" class="sort" data-sort="status">Diri({{ $mergedRoleBreakdown['diri']['actual_weight'] }}%)</th>
                                <th scope="col" class="sort" data-sort="status">Rekan Kerja({{ $mergedRoleBreakdown['rekan_kerja']['actual_weight'] }}%)</th>
                                <th scope="col" class="sort" data-sort="status">Bawahan({{ $mergedRoleBreakdown['bawahan']['actual_weight'] }}%)</th>
                                <th scope="col" class="sort" data-sort="status">Actual Level</th>
                                <th scope="col" class="sort" data-sort="status">Required Level</th>
                                <th scope="col" class="sort" data-sort="status">Gap</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @if(isset($competencies))
                                @foreach($competencies as $index => $competencyData)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $index }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        <span class="text-muted">
                                            @if(isset($mergedRoleBreakdown['atasan']['assessments']) && $mergedRoleBreakdown['atasan']['assessments']->isNotEmpty())
                                                {{ number_format($mergedRoleBreakdown['atasan']['assessments']->avg($competencyMapping[$index] . '_rating'), 1) }}
                                            @else
                                                <span class="text-warning">No Data</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            @if(isset($mergedRoleBreakdown['diri']['assessments']) && $mergedRoleBreakdown['diri']['assessments']->isNotEmpty())
                                                {{ number_format($mergedRoleBreakdown['diri']['assessments']->avg($competencyMapping[$index] . '_rating'), 1) }}
                                            @else
                                                <span class="text-warning">No Data</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            @if(isset($mergedRoleBreakdown['rekan_kerja']['assessments']) && $mergedRoleBreakdown['rekan_kerja']['assessments']->isNotEmpty())
                                                {{ number_format($mergedRoleBreakdown['rekan_kerja']['assessments']->avg($competencyMapping[$index] . '_rating'), 1) }}
                                            @else
                                                <span class="text-warning">No Data</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            @if(isset($mergedRoleBreakdown['bawahan']['assessments']) && $mergedRoleBreakdown['bawahan']['assessments']->isNotEmpty())
                                                {{ number_format($mergedRoleBreakdown['bawahan']['assessments']->avg($competencyMapping[$index] . '_rating'), 1) }}
                                            @else
                                                <span class="text-warning">No Data</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $competencyData['actual'] !== null ? number_format($competencyData['actual'], 2) : 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $competencyData['expected'] !== null ? $competencyData['expected'] : 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($competencyData['gap'] !== null)
                                            @php
                                                // Calculate the true gap: Actual - Expected (positive = surplus, negative = deficit)
                                                $trueGap = $competencyData['actual'] - $competencyData['expected'];
                                            @endphp
                                            
                                            @if($trueGap > 0)
                                                <i class="fas fa-arrow-up text-success mr-3"></i>
                                                <span class="text-success">+{{ number_format($trueGap, 2) }}</span>
                                                <small class="text-muted d-block">Above Required</small>
                                            @elseif($trueGap < 0)
                                                <i class="fas fa-arrow-down text-danger mr-3"></i>
                                                <span class="text-danger">{{ number_format($trueGap, 2) }}</span>
                                                <small class="text-muted d-block">Below Required</small>
                                            @else
                                                <i class="fas fa-check text-success mr-3"></i>
                                                <span class="text-success">0.00</span>
                                                <small class="text-muted d-block">Meets Required</small>
                                            @endif
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No gap analysis data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="fas fa-angle-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-angle-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Detail Assessment Records</h3>
                    <p class="text-muted mb-0">Individual assessment submissions from reviewers</p>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">No.</th>
                                <th scope="col" class="sort" data-sort="budget">Reviewer</th>
                                <th scope="col" class="sort" data-sort="status">Reviewee</th>
                                <th scope="col" class="sort" data-sort="status">Departemen</th>
                                <th scope="col" class="sort" data-sort="status">Fungsi</th>
                                <th scope="col" class="sort" data-sort="status">Peran</th>
                                <th scope="col" class="sort" data-sort="status">Risk Mgmt</th>
                                <th scope="col" class="sort" data-sort="status">Bus. Cont.</th>
                                <th scope="col" class="sort" data-sort="status">Personnel Mgmt</th>
                                <th scope="col" class="sort" data-sort="status">Global Tech</th>
                                <th scope="col" class="sort" data-sort="status">Physical Sec</th>
                                <th scope="col" class="sort" data-sort="status">Practical Sec</th>
                                <th scope="col" class="sort" data-sort="status">Cyber Sec</th>
                                <th scope="col" class="sort" data-sort="status">Investigation</th>
                                <th scope="col" class="sort" data-sort="status">Bus. Intel</th>
                                <th scope="col" class="sort" data-sort="status">Basic Intel</th>
                                <th scope="col" class="sort" data-sort="status">Mass Conflict</th>
                                <th scope="col" class="sort" data-sort="status">Legal</th>
                                <th scope="col" class="sort" data-sort="status">Disaster Mgmt</th>
                                <th scope="col" class="sort" data-sort="status">SAR</th>
                                <th scope="col" class="sort" data-sort="status">Assessor</th>
                                <th scope="col">Submission Date</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($dataTable as $index => $item)
                            <tr>
                                <td>
                                    <span class="text-muted">{{$index+1}}</span>
                                </td>
                                <td class="budget">
                                    <strong>{{$item->reviewer_name}}</strong>
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->reviewee_name}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->departemen}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->fungsi}}</span>
                                </td>
                                <td>
                                    <span class="badge badge-{{$item->display_role == 'Atasan Langsung' ? 'success' : (in_array($item->display_role, ['Rekan Kerja 1', 'Rekan Kerja 2']) ? 'primary' : 'warning')}}">
                                        {{$item->display_role}}
                                    </span>
                                </td>
                                <!-- Risk Management -->
                                <td>
                                    @if($item->risk_management_rating)
                                        <span class="badge badge-{{$item->risk_management_rating >= 3 ? 'success' : ($item->risk_management_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->risk_management_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Business Continuity -->
                                <td>
                                    @if($item->business_continuity_rating)
                                        <span class="badge badge-{{$item->business_continuity_rating >= 3 ? 'success' : ($item->business_continuity_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->business_continuity_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Personnel Management -->
                                <td>
                                    @if($item->personnel_management_rating)
                                        <span class="badge badge-{{$item->personnel_management_rating >= 3 ? 'success' : ($item->personnel_management_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->personnel_management_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Global Tech Awareness -->
                                <td>
                                    @if($item->global_tech_awareness_rating)
                                        <span class="badge badge-{{$item->global_tech_awareness_rating >= 3 ? 'success' : ($item->global_tech_awareness_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->global_tech_awareness_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Physical Security -->
                                <td>
                                    @if($item->physical_security_rating)
                                        <span class="badge badge-{{$item->physical_security_rating >= 3 ? 'success' : ($item->physical_security_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->physical_security_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Practical Security -->
                                <td>
                                    @if($item->practical_security_rating)
                                        <span class="badge badge-{{$item->practical_security_rating >= 3 ? 'success' : ($item->practical_security_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->practical_security_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Cyber Security -->
                                <td>
                                    @if($item->cyber_security_rating)
                                        <span class="badge badge-{{$item->cyber_security_rating >= 3 ? 'success' : ($item->cyber_security_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->cyber_security_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Investigation Case Management -->
                                <td>
                                    @if($item->investigation_case_mgmt_rating)
                                        <span class="badge badge-{{$item->investigation_case_mgmt_rating >= 3 ? 'success' : ($item->investigation_case_mgmt_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->investigation_case_mgmt_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Business Intelligence -->
                                <td>
                                    @if($item->business_intelligence_rating)
                                        <span class="badge badge-{{$item->business_intelligence_rating >= 3 ? 'success' : ($item->business_intelligence_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->business_intelligence_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Basic Intelligence -->
                                <td>
                                    @if($item->basic_intelligence_rating)
                                        <span class="badge badge-{{$item->basic_intelligence_rating >= 3 ? 'success' : ($item->basic_intelligence_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->basic_intelligence_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Mass Conflict Management -->
                                <td>
                                    @if($item->mass_conflict_mgmt_rating)
                                        <span class="badge badge-{{$item->mass_conflict_mgmt_rating >= 3 ? 'success' : ($item->mass_conflict_mgmt_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->mass_conflict_mgmt_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Legal Compliance -->
                                <td>
                                    @if($item->legal_compliance_rating)
                                        <span class="badge badge-{{$item->legal_compliance_rating >= 3 ? 'success' : ($item->legal_compliance_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->legal_compliance_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Disaster Management -->
                                <td>
                                    @if($item->disaster_management_rating)
                                        <span class="badge badge-{{$item->disaster_management_rating >= 3 ? 'success' : ($item->disaster_management_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->disaster_management_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- SAR -->
                                <td>
                                    @if($item->sar_rating)
                                        <span class="badge badge-{{$item->sar_rating >= 3 ? 'success' : ($item->sar_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->sar_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- Assessor -->
                                <td>
                                    @if($item->assessor_rating)
                                        <span class="badge badge-{{$item->assessor_rating >= 3 ? 'success' : ($item->assessor_rating == 2 ? 'warning' : 'danger')}}">
                                            {{$item->assessor_rating}}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{date('d M Y', strtotime($item->submission_date))}}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="fas fa-angle-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-angle-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    @include('dashboard.layouts._footer')
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== GAP DISTRIBUTION CHART DEBUG ===');
    console.log('gapAnalysis exists:', {{ isset($gapAnalysis) ? 'true' : 'false' }});
    console.log('gapAnalysis value:', {!! json_encode($gapAnalysis) !!});
    console.log('competencies exists:', {{ isset($competencies) ? 'true' : 'false' }});
    console.log('competencies value:', {!! json_encode($competencies) !!});
    console.log('competencies count:', {{ is_array($competencies) ? count($competencies) : 0 }});
    
    @if(isset($gapAnalysis) && isset($competencies) && count($competencies) > 0)
    console.log('✅ CONDITIONS MET: Proceeding with chart rendering...');
    // Gap Analysis Chart Data
    const competencyNames = [];
    const actualValues = [];
    const expectedValues = [];
    const gapValues = [];
    
    @foreach($competencies as $name => $data)
        @if($data['actual'] !== null && $data['expected'] !== null)
            // Create shorter, more readable competency names
            var shortName = '{{ $name }}';
            if (shortName.length > 20) {
                // Smart truncation - keep important words
                shortName = shortName.replace('Management', 'Mgmt')
                                   .replace('Intelligence', 'Intel')
                                   .replace('Technology', 'Tech')
                                   .replace('Awareness', 'Aware')
                                   .replace('Investigation', 'Invest')
                                   .replace('Continuity', 'Cont');
                if (shortName.length > 18) {
                    shortName = shortName.substring(0, 15) + '...';
                }
            }
            competencyNames.push(shortName);
            actualValues.push({{ floatval($data['actual']) }});
            expectedValues.push({{ floatval($data['expected']) }});
            // Calculate true gap: Actual - Expected (positive = surplus, negative = deficit)
            gapValues.push({{ floatval($data['actual']) - floatval($data['expected']) }});
        @endif
    @endforeach
    
    // Gap Analysis Bar Chart (Original - Actual vs Expected)
    const gapCtx = document.getElementById('gapChart').getContext('2d');
    new Chart(gapCtx, {
        type: 'bar',
        data: {
            labels: competencyNames,
            datasets: [{
                label: 'Actual Level',
                data: actualValues,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Expected Level',
                data: expectedValues,
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 4,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Actual vs Expected Competency Levels'
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
    
    // Gap Distribution Chart using ApexCharts - Modern & Beautiful
    console.log('🚀 Creating ApexCharts Gap Distribution...');
    console.log('Gap values:', gapValues);
    console.log('Competency names:', competencyNames);
    
    // Clear any existing chart instance
    if (window.gapDistributionChartInstance) {
        window.gapDistributionChartInstance.destroy();
    }
    
    // Create colors array based on gap values (red for negative, blue for positive)
    const gapColors = gapValues.map(gap => {
        if (gap > 0) return '#36A2EB'; // Blue for positive
        else if (gap < 0) return '#FF6384'; // Red for negative  
        else return '#4BC0C0'; // Teal for zero
    });
    
    // Prepare data for ApexCharts
    const gapSeriesData = gapValues.map((value, index) => ({
        x: competencyNames[index],
        y: value,
        fillColor: gapColors[index]
    }));
    
    const gapDistOptions = {
        series: [{
            name: 'Gap Score',
            data: gapSeriesData
        }],
        chart: {
            type: 'bar',
            height: 380,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            }
        },
        title: {
            text: 'Gap Distribution - Performance vs Requirements',
            align: 'left',
            style: {
                fontSize: '16px',
                fontWeight: 'bold'
            }
        },
        plotOptions: {
            bar: {
                distributed: true,
                horizontal: false,
                columnWidth: '60%',
                borderRadius: 2
            }
        },
        colors: gapColors,
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        xaxis: {
            type: 'category',
            title: {
                text: 'Competencies',
                style: {
                    fontSize: '12px',
                    fontWeight: 600
                }
            },
            labels: {
                rotate: -45,
                style: {
                    fontSize: '10px'
                },
                formatter: function(value) {
                    return value.length > 15 ? value.substring(0, 12) + '...' : value;
                }
            }
        },
        yaxis: {
            title: {
                text: 'Gap Score (+ Above Required, - Below Required)',
                style: {
                    fontSize: '12px',
                    fontWeight: 600
                }
            },
            labels: {
                formatter: function(value) {
                    return value > 0 ? '+' + value.toFixed(1) : value.toFixed(1);
                }
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.1
            },
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        annotations: {
            yaxis: [{
                y: 0,
                borderColor: '#000000',
                borderWidth: 3,
                strokeDashArray: 0,
                label: {
                    text: 'Required Level',
                    style: {
                        color: '#fff',
                        background: '#000000',
                        fontSize: '10px'
                    }
                }
            }]
        },
        tooltip: {
            shared: false,
            intersect: true,
            custom: function({series, seriesIndex, dataPointIndex, w}) {
                const value = series[seriesIndex][dataPointIndex];
                const competency = w.globals.labels[dataPointIndex];
                const status = value > 0 ? 'Above Required' : value < 0 ? 'Below Required' : 'Meets Required';
                const displayValue = value > 0 ? '+' + value.toFixed(1) : value.toFixed(1);
                const color = value > 0 ? '#36A2EB' : value < 0 ? '#FF6384' : '#4BC0C0';
                
                return `
                    <div style="padding: 10px; background: white; border: 1px solid #e7e7e7; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <div style="font-weight: bold; margin-bottom: 5px; color: #333;">${competency}</div>
                        <div style="color: ${color}; font-weight: 600;">${status}: ${displayValue}</div>
                    </div>
                `;
            }
        },
        responsive: [{
            breakpoint: 768,
            options: {
                plotOptions: {
                    bar: {
                        columnWidth: '80%'
                    }
                },
                xaxis: {
                    labels: {
                        rotate: -90
                    }
                }
            }
        }]
    };
    
    // Create the ApexChart
    window.gapDistributionChartInstance = new ApexCharts(
        document.querySelector("#gapDistributionChart"), 
        gapDistOptions
    );
    
    window.gapDistributionChartInstance.render().then(() => {
        console.log('✅ ApexCharts Gap Distribution created successfully!');
    }).catch(error => {
        console.error('❌ ApexCharts Error:', error);
    });
    
    @else
    console.log('❌ CHART RENDERING SKIPPED: No data available');
    console.log('Condition failed - gapAnalysis:', {{ isset($gapAnalysis) ? 'true' : 'false' }}, 'competencies count:', {{ is_array($competencies) ? count($competencies) : 0 }});
    @endif
    
    @if(isset($roleBreakdown))
    // Assessment Breakdown Pie Chart
    const assessmentCtx = document.getElementById('assessmentBreakdownChart').getContext('2d');
    new Chart(assessmentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Self Assessment', 'Atasan', 'Rekan Kerja'],
            datasets: [{
                data: [
                    {{ $roleBreakdown['self']['count'] }},
                    {{ $roleBreakdown['atasan']['count'] }},
                    {{ $roleBreakdown['rekan_kerja']['count'] }}
                ],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)', 
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Assessment Sources ({{ $roleBreakdown['self']['count'] + $roleBreakdown['atasan']['count'] + $roleBreakdown['rekan_kerja']['count'] }} total)'
                },
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
    
    
    @endif
});
</script>
@endsection