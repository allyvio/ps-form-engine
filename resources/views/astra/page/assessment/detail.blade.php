@extends('dashboard.layouts._master')
@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{ $breadcrumb2 }}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/astra/assessment-data') }}">{{ $breadcrumb1 }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb2 }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ url('/astra/assessment-data') }}" class="btn btn-sm btn-neutral">
                        <i class="ni ni-bold-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="h3 mb-0">Assessment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading">{{ $assessment->submission_date ? $assessment->submission_date->format('M j, Y') : 'N/A' }}</span>
                                    <span class="description">Submission Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <hr class="my-4">
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>Assessment ID: {{ $assessment->submission_id }}
                        </div>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>{{ $assessment->departemen }} - {{ $assessment->fungsi }}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>{{ $assessment->peran }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="h3 mb-0">Reviewer → Reviewee</h5>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                        <div class="timeline-block">
                            <span class="timeline-step badge-success">
                                <i class="ni ni-single-02"></i>
                            </span>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted font-weight-bold">Reviewer (Penilai)</small>
                                        <h6 class="text-sm mb-0">{{ $assessment->reviewer_name }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step badge-warning">
                                <i class="ni ni-user-run"></i>
                            </span>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted font-weight-bold">Reviewee (Yang Dinilai)</small>
                                        <h6 class="text-sm mb-0">{{ $assessment->reviewee_name }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">15 Core Competencies Assessment</h3>
                        </div>
                        <div class="col text-right">
                            @php
                                $ratedCount = 0;
                                foreach($competencies as $name => $data) {
                                    if($data['rating'] > 0) $ratedCount++;
                                }
                            @endphp
                            <span class="badge badge-primary">{{ $ratedCount }}/15 Competencies Rated</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($competencies as $competencyName => $data)
                    <div class="row align-items-center mb-4">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div class="mr-4">
                                    @php
                                        $rating = $data['rating'];
                                        $badgeClass = 'secondary';
                                        $levelText = 'Not Rated';
                                        if($rating == 1) { $badgeClass = 'danger'; $levelText = 'Basic'; }
                                        elseif($rating == 2) { $badgeClass = 'warning'; $levelText = 'Intermediate'; }
                                        elseif($rating == 3) { $badgeClass = 'info'; $levelText = 'Middle'; }
                                        elseif($rating == 4) { $badgeClass = 'success'; $levelText = 'Executive'; }
                                    @endphp
                                    <span class="badge badge-{{ $badgeClass }} badge-pill">{{ $rating ?: 0 }}/4</span>
                                </div>
                                <div class="flex-fill">
                                    <h6 class="text-sm font-weight-bold mb-1">{{ $competencyName }}</h6>
                                    <div class="progress progress-xs mb-0">
                                        <div class="progress-bar bg-{{ $badgeClass }}" role="progressbar" 
                                             style="width: {{ $rating ? ($rating/4)*100 : 0 }}%" 
                                             aria-valuenow="{{ $rating ?: 0 }}" aria-valuemin="0" aria-valuemax="4">
                                        </div>
                                    </div>
                                    <small class="text-muted">Level: {{ $levelText }}</small>
                                </div>
                            </div>
                            @if($data['narrative'])
                            <div class="mt-2">
                                <small class="text-muted font-weight-bold">Narrative:</small>
                                <p class="text-sm mb-0 mt-1">{{ $data['narrative'] }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <hr class="my-3">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection