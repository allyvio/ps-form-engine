@extends('astra.layouts._master')

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
        <div class="col-xl-4 order-xl-2">
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
                                    <span class="heading">{{$countPenilai}}</span>
                                    <span class="description">Menilai</span>
                                </div>
                                <div>
                                    <span class="heading">{{count($dataTable)}}</span>
                                    <span class="description">Dinilai</span>
                                </div>
                                <div>
                                    <span class="heading">{{$countPenilai + count($dataTable)}}</span>
                                    <span class="description">Partisipasi</span>
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
                            <i class="ni business_briefcase-24 mr-2"></i>{{$detailPeserta->jabatan}} - {{$detailPeserta->departemen}}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>Astra International
                        </div>
                    </div>
                </div>
            </div>
            <!-- Progress track -->
            <div class="card bg-gradient-dark border-0">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Individual Report</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">Download</span>
                        </div>
                        <div class="col-auto">
                            <a href="{{url('download-report')}}">
                                <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                    <i class="ni ni-cloud-download-95"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> 2x</span>
                        <span class="text-nowrap text-light">diunduh</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card bg-gradient-info border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0 text-white">Actual Level</h5>
                                    <span class="h2 font-weight-bold mb-0 text-white">1</span>
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
                                    <h5 class="card-title text-uppercase text-muted mb-0 text-white">GAP</h5>
                                    <span class="h2 font-weight-bold mb-0 text-white">-2</span>
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
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-xl-6">
                            <!--* Card header *-->
                            <!--* Card body *-->
                            <!--* Card init *-->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header">
                                    <!-- Surtitle -->
                                    <h6 class="surtitle">Hasil penilaian</h6>
                                    <!-- Title -->
                                    <h5 class="h3 mb-0">Nilai kategori</h5>
                                </div>
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="chart">
                                        <!-- Chart wrapper -->
                                        <canvas id="chart-doughnut" class="chart-canvas"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <!--* Card header *-->
                            <!--* Card body *-->
                            <!--* Card init *-->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header">
                                    <!-- Surtitle -->
                                    <h6 class="surtitle">Bobot penilaian</h6>
                                    <!-- Title -->
                                    <h5 class="h3 mb-0">Persentase</h5>
                                </div>
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="chart">
                                        <!-- Chart wrapper -->
                                        <canvas id="chart-pie" class="chart-canvas"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <th scope="col" class="sort" data-sort="status">Atasan(60%)</th>
                                <th scope="col" class="sort" data-sort="status">Diri(20%)</th>
                                <th scope="col" class="sort" data-sort="status">Rekan Kerja (20%)</th>
                                <th scope="col" class="sort" data-sort="status">Actual Level</th>
                                <th scope="col" class="sort" data-sort="status">Required Level</th>
                                <th scope="col" class="sort" data-sort="status">Gap</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <tr>
                                <td>
                                    1.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Risk Management</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['risk_management']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['risk_management']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['risk_management'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['risk_management']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">3</span>
                                </td>
                                <td>
                                    @if($calculateGap['risk_management'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['risk_management'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['risk_management']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Business Continuity</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['business_continuity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['business_continuity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['business_continuity'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['business_continuity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">3</span>
                                </td>
                                <td>
                                    @if($calculateGap['business_continuity'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['business_continuity'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['business_continuity']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    3.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Personnel Management</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['personnel_management']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['personnel_management']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['personnel_management'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['personnel_management']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">1</span>
                                </td>
                                <td>
                                    @if($calculateGap['personnel_management'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['personnel_management'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['personnel_management']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    4.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Global & Technological Awareness</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['globalTechnologicalAwareness']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['globalTechnologicalAwareness']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['globalTechnologicalAwareness'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['globalTechnologicalAwareness']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">2</span>
                                </td>
                                <td>
                                    @if($calculateGap['globalTechnologicalAwareness'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['globalTechnologicalAwareness'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['globalTechnologicalAwareness']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    5.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Physical Security </span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['physicalSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['physicalSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['physicalSecurity'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['physicalSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">2</span>
                                </td>
                                <td>
                                    @if($calculateGap['physicalSecurity'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['physicalSecurity'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['physicalSecurity']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    6.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Practical Security</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['practicalSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['practicalSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['practicalSecurity'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['practicalSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">N/A</span>
                                </td>
                                <td>
                                    @if($calculateGap['practicalSecurity'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['practicalSecurity'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">N/A</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    7.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Cyber Security</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['cyberSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['cyberSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['cyberSecurity'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['cyberSecurity']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">2</span>
                                </td>
                                <td>
                                    @if($calculateGap['cyberSecurity'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['cyberSecurity'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['cyberSecurity']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    8.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Investigation & Case Management</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['investigationCaseManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['investigationCaseManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['investigationCaseManagement'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['investigationCaseManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">2</span>
                                </td>
                                <td>
                                    @if($calculateGap['investigationCaseManagement'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['investigationCaseManagement'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['investigationCaseManagement']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    9.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Business Intelligence</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['businessIntelligence']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['businessIntelligence']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['businessIntelligence'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['businessIntelligence']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">3</span>
                                </td>
                                <td>
                                    @if($calculateGap['businessIntelligence'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['businessIntelligence'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['businessIntelligence']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    10.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Basic Intelligent </span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['basicIntelligent']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['basicIntelligent']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['basicIntelligent'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['basicIntelligent']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">3</span>
                                </td>
                                <td>
                                    @if($calculateGap['basicIntelligent'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['basicIntelligent'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['basicIntelligent']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    11.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Mass & Conflict Management</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['massConflictManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['massConflictManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['massConflictManagement'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['massConflictManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">3</span>
                                </td>
                                <td>
                                    @if($calculateGap['massConflictManagement'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['massConflictManagement'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['massConflictManagement']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    12.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Legal & Compliance </span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['legalCompliance']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['legalCompliance']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['legalCompliance'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['legalCompliance']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">2</span>
                                </td>
                                <td>
                                    @if($calculateGap['legalCompliance'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['legalCompliance'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['legalCompliance']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    13.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Disaster Management</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['disasterManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['disasterManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['disasterManagement'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['disasterManagement']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">2</span>
                                </td>
                                <td>
                                    @if($calculateGap['disasterManagement'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['disasterManagement'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">{{$calculateGap['disasterManagement']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    14.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">SAR </span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['searchAndRescue']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['searchAndRescue']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['searchAndRescue'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['searchAndRescue']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">N/A</span>
                                </td>
                                <td>
                                    @if($calculateGap['searchAndRescue'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['searchAndRescue'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">N/A</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    15.
                                </td>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">Assessor</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-muted">{{$calculateAtasan['assessor']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateSelf['assessor']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{number_format($calculateRekanKerja['assessor'],1)}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$calculateActualLevel['assessor']}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">N/A</span>
                                </td>
                                <td>
                                    @if($calculateGap['assessor'] < 0)
                                        <i class="fas fa-arrow-down text-danger mr-3"></i>
                                        @elseif($calculateGap['assessor'] > 0)
                                        <i class="fas fa-arrow-up text-success mr-3"></i>
                                        @endif
                                        <span class="text-muted">N/A</span>
                                </td>
                            </tr>
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
                    <h3 class="mb-0">Penilaian peranan</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">No.</th>
                                <th scope="col" class="sort" data-sort="budget">Nama rater</th>
                                <th scope="col" class="sort" data-sort="status">Departemen</th>
                                <th scope="col" class="sort" data-sort="status">Fungsi</th>
                                <th scope="col" class="sort" data-sort="status">Peran</th>
                                <th scope="col" class="sort" data-sort="status">Question 1</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($dataTable as $index => $item)
                            <tr>
                                <td>
                                    <span class="text-muted">{{$index+1}}</span>
                                </td>
                                <td class="budget">
                                    {{$item->name}}
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->departemen}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->fungsi}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->peran}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->question_1_value}}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{$item->date_created}}</span>
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
@endsection