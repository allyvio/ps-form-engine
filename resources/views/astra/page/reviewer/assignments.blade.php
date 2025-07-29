@extends('dashboard.layouts._master')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
        @include('dashboard.layouts._breadcrumb')
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Assignments</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $assignments->count() * 6 }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-chart-pie-35"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">Total reviewer assignments</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Participants</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $assignments->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="ni ni-single-02"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">With reviewer assignments</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Avg per Person</h5>
                      <span class="h2 font-weight-bold mb-0">6</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">Reviewers per participant</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Assessment Count</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $assignments->flatten()->sum('assessment_count') }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-paper-diploma"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">Total assessments completed</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Reviewer Assignment Matrix</h3>
            </div>
            <!-- Table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Reviewee (Yang Dinilai)</th>
                    <th scope="col">Atasan Langsung</th>
                    <th scope="col">Diri Sendiri</th>
                    <th scope="col">Rekan Kerja 1</th>
                    <th scope="col">Rekan Kerja 2</th>
                    <th scope="col">Bawahan/RK 3</th>
                    <th scope="col">Bawahan/RK 4</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($assignments as $revieweeId => $reviewerGroup)
                  @php
                    $revieweeData = $reviewerGroup->first();
                    $totalAssessments = $reviewerGroup->sum('assessment_count');
                  @endphp
                  <tr>
                    <td>
                      <span class="badge badge-dot">
                        <i class="bg-primary"></i>
                        {{ $revieweeId }}
                      </span>
                    </td>
                    <td>
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm font-weight-bold">{{ $revieweeData->reviewee_name }}</span>
                        </div>
                      </div>
                    </td>
                    @foreach(['Atasan Langsung', 'Diri Sendiri', 'Rekan Kerja 1', 'Rekan Kerja 2', 'Bawahan Langsung 1', 'Bawahan Langsung 2'] as $role)
                      @php
                        $reviewer = $reviewerGroup->where('reviewer_role', $role)->first();
                      @endphp
                      <td>
                        @if($reviewer)
                          <div class="d-flex flex-column">
                            <span class="text-sm font-weight-bold">{{ $reviewer->reviewer_name }}</span>
                            <small class="text-muted">
                              @if($reviewer->assessment_count > 0)
                                <span class="badge badge-success">{{ $reviewer->assessment_count }} assessments</span>
                              @else
                                <span class="badge badge-secondary">No assessment</span>
                              @endif
                            </small>
                          </div>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    @endforeach
                    <td>
                      <span class="badge badge-primary badge-pill">{{ $totalAssessments }}</span>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      @include('dashboard.layouts._footer')
    </div>
@endsection