@extends('dashboard.layouts._master')
@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{ $breadcrumb1 }}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb1 }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Assessments</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $stats['total_assessments'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="ni ni-collection"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Active Reviewers</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $stats['total_reviewers'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                        <i class="ni ni-single-02"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Reviewees</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $stats['total_reviewees'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                        <i class="ni ni-chart-pie-35"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Departments</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $stats['departments']->count() }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                        <i class="ni ni-building"></i>
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

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Assessment Records</h3>
                        </div>
                        <div class="col text-right">
                            <span class="badge badge-primary">{{ $assessments->total() }} Total Records</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="date">Date</th>
                                <th scope="col" class="sort" data-sort="reviewer">Reviewer</th>
                                <th scope="col" class="sort" data-sort="reviewee">Reviewee</th>
                                <th scope="col" class="sort" data-sort="department">Department</th>
                                <th scope="col" class="sort" data-sort="role">Role</th>
                                <th scope="col">Competencies</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($assessments as $assessment)
                            <tr>
                                <td class="date">
                                    <span class="badge badge-dot mr-4">
                                        <i class="bg-info"></i>
                                        <span>{{ $assessment->submission_date ? $assessment->submission_date->format('M j, Y') : 'N/A' }}</span>
                                    </span>
                                </td>
                                <td class="reviewer">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm font-weight-bold">{{ $assessment->reviewer_name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="reviewee">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{ $assessment->reviewee_name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="department">
                                    <span class="badge badge-secondary">{{ $assessment->departemen ?: 'N/A' }}</span>
                                </td>
                                <td class="role">
                                    <span class="text-sm">{{ $assessment->peran ?: 'N/A' }}</span>
                                </td>
                                <td>
                                    @php
                                        $competencyCount = 0;
                                        $competencies = [
                                            'risk_management_rating', 'business_continuity_rating', 'personnel_management_rating',
                                            'global_tech_awareness_rating', 'physical_security_rating', 'practical_security_rating',
                                            'cyber_security_rating', 'investigation_case_mgmt_rating', 'business_intelligence_rating',
                                            'basic_intelligence_rating', 'mass_conflict_mgmt_rating', 'legal_compliance_rating',
                                            'disaster_management_rating', 'sar_rating', 'assessor_rating'
                                        ];
                                        foreach($competencies as $comp) {
                                            if($assessment->$comp > 0) $competencyCount++;
                                        }
                                    @endphp
                                    <span class="badge badge-success">{{ $competencyCount }}/15 Rated</span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ url('/astra/assessment-data/' . $assessment->id) }}" class="btn btn-sm btn-primary">
                                        <i class="ni ni-zoom-split-in"></i> View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <p class="text-sm text-muted mb-0">
                                Showing {{ $assessments->firstItem() }} to {{ $assessments->lastItem() }} of {{ $assessments->total() }} results
                            </p>
                        </div>
                        <div class="col-lg-6">
                            {{ $assessments->links('custom.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection