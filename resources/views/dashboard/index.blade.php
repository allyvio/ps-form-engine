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
                      <h5 class="card-title text-uppercase text-muted mb-0">Astra Peserta</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $analyticalData['totalPeserta'] }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-single-02"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $analyticalData['gapAnalysisCompletionRate'] }}%</span>
                    <span class="text-muted">Gap analysis selesai</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Assessment</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $analyticalData['totalAssessments'] }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="ni ni-paper-diploma"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-info mr-2"><i class="fa fa-users"></i> {{ $analyticalData['totalReviewers'] }}</span>
                    <span class="text-muted">Total penilai aktif</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Departments</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $analyticalData['totalDepartments'] }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-building"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-warning mr-2"><i class="fa fa-chart-bar"></i> {{ number_format($analyticalData['overallPerformance'], 1) }}</span>
                    <span class="text-muted">Avg. performance level</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Recommendation</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $analyticalData['recommendationStats']['memenuhi'] + $analyticalData['recommendationStats']['cukup_memenuhi'] }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-check-bold"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-thumbs-up"></i> {{ round((($analyticalData['recommendationStats']['memenuhi'] + $analyticalData['recommendationStats']['cukup_memenuhi']) / $analyticalData['gapAnalysisCompleted']) * 100, 1) }}%</span>
                    <span class="text-muted">Meet criteria</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Additional Analytics Row -->
          <div class="row mt-4">
            <div class="col-xl-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="mb-0">Assessment by Role Distribution</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    @php 
                    $roleMapping = [
                      'Atasan Langsung' => 'Atasan',
                      'Diri Sendiri' => 'Self',
                      'Rekan Kerja 1' => 'Rekan Kerja 1',
                      'Rekan Kerja 2' => 'Rekan Kerja 2',
                      'Bawahan Langsung 1' => 'Bawahan 1',
                      'Bawahan Langsung 2' => 'Bawahan 2'
                    ];
                    $groupedRoles = [
                      'Atasan' => ($analyticalData['assessmentsByRole']['Atasan Langsung'] ?? 0),
                      'Self' => ($analyticalData['assessmentsByRole']['Diri Sendiri'] ?? 0),
                      'Rekan Kerja' => ($analyticalData['assessmentsByRole']['Rekan Kerja 1'] ?? 0) + ($analyticalData['assessmentsByRole']['Rekan Kerja 2'] ?? 0),
                      'Bawahan' => ($analyticalData['assessmentsByRole']['Bawahan Langsung 1'] ?? 0) + ($analyticalData['assessmentsByRole']['Bawahan Langsung 2'] ?? 0)
                    ];
                    @endphp
                    @foreach($groupedRoles as $role => $count)
                    <div class="col-6 mb-3">
                      <div class="text-center">
                        <h4 class="text-primary">{{ $count }}</h4>
                        <p class="text-muted mb-0">{{ $role }}</p>
                        <div class="progress mt-2">
                          <div class="progress-bar bg-gradient-primary" style="width: {{ $analyticalData['totalAssessments'] > 0 ? ($count / $analyticalData['totalAssessments']) * 100 : 0 }}%"></div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="mb-0">Recommendation Categories</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    @php 
                    $recommendationCategories = [
                      'memenuhi' => ['label' => 'Memenuhi Kriteria', 'color' => 'success'],
                      'cukup_memenuhi' => ['label' => 'Cukup Memenuhi', 'color' => 'info'],
                      'kurang_memenuhi' => ['label' => 'Kurang Memenuhi', 'color' => 'warning'],
                      'belum_memenuhi' => ['label' => 'Belum Memenuhi', 'color' => 'danger']
                    ];
                    @endphp
                    @foreach($recommendationCategories as $key => $category)
                    <div class="col-6 mb-3">
                      <div class="text-center">
                        <h4 class="text-{{ $category['color'] }}">{{ $analyticalData['recommendationStats'][$key] }}</h4>
                        <p class="text-muted mb-0">{{ $category['label'] }}</p>
                        <div class="progress mt-2">
                          <div class="progress-bar bg-gradient-{{ $category['color'] }}" style="width: {{ $analyticalData['gapAnalysisCompleted'] > 0 ? ($analyticalData['recommendationStats'][$key] / $analyticalData['gapAnalysisCompleted']) * 100 : 0 }}%"></div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Content Tabs -->
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Tab Navigation -->
            <div class="card-header border-0">
              <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-dashboard-tab" data-toggle="tab" href="#tabs-dashboard" role="tab" aria-controls="tabs-dashboard" aria-selected="true">
                    <i class="ni ni-tv-2 mr-2"></i>Dashboard Overview
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" id="tabs-peserta-tab" data-toggle="tab" href="#tabs-peserta" role="tab" aria-controls="tabs-peserta" aria-selected="false">
                    <i class="ni ni-single-02 mr-2"></i>Peserta Astra
                  </a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="myTabContent">
                <!-- Dashboard Tab -->
                <div class="tab-pane fade show active" id="tabs-dashboard" role="tabpanel" aria-labelledby="tabs-dashboard-tab">
                  <div class="row">
                    <div class="col-xl-8">
                      <div class="card">
                        <div class="card-header border-0">
                          <div class="row align-items-center">
                            <div class="col">
                              <h3 class="mb-0">Top Performing Competencies</h3>
                            </div>
                          </div>
                        </div>
                        <div class="table-responsive">
                          <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">Competency</th>
                                <th scope="col">Avg. Level</th>
                                <th scope="col">Performance</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach(array_slice($analyticalData['competencyPerformance'], 0, 10, true) as $competency => $avgLevel)
                              <tr>
                                <th scope="row">{{ $competency }}</th>
                                <td>{{ $avgLevel }}</td>
                                <td>
                                  <div class="d-flex align-items-center">
                                    <span class="mr-2">{{ number_format(($avgLevel / 4) * 100, 1) }}%</span>
                                    <div>
                                      <div class="progress">
                                        <div class="progress-bar bg-gradient-{{ $avgLevel >= 3.5 ? 'success' : ($avgLevel >= 2.5 ? 'info' : ($avgLevel >= 1.5 ? 'warning' : 'danger')) }}" role="progressbar" 
                                             style="width: {{ ($avgLevel / 4) * 100 }}%;"></div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-4">
                      <div class="card">
                        <div class="card-header">
                          <h5 class="h3 mb-0">Departemen Overview</h5>
                        </div>
                        <div class="card-body">
                          @php
                            $departemen = \App\Models\FormOtherAstra::selectRaw('departemen, count(distinct reviewee_id) as total')
                                ->whereNotNull('departemen')
                                ->where('departemen', '!=', '')
                                ->groupBy('departemen')
                                ->orderBy('total', 'desc')
                                ->limit(5)
                                ->get();
                          @endphp
                          @foreach($departemen as $dept)
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                              <h6 class="mb-0">{{ $dept->departemen }}</h6>
                              <small class="text-muted">{{ $dept->total }} peserta</small>
                            </div>
                            <div class="text-right">
                              <span class="badge badge-primary">{{ number_format(($dept->total / $analyticalData['totalPeserta']) * 100, 1) }}%</span>
                            </div>
                          </div>
                          @endforeach
                        </div>
                      </div>
                      
                      <div class="card mt-4">
                        <div class="card-header">
                          <h5 class="h3 mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                          <div class="list-group list-group-flush list my--3">
                            <div class="list-group-item px-0">
                              <div class="row align-items-center">
                                <div class="col-auto">
                                  <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                    <i class="ni ni-single-02"></i>
                                  </div>
                                </div>
                                <div class="col ml--2">
                                  <h4 class="mb-0">
                                    <a href="{{ url('/astra/peserta') }}">Peserta Astra</a>
                                  </h4>
                                  <small>Kelola data karyawan Astra</small>
                                </div>
                              </div>
                            </div>
                            <div class="list-group-item px-0">
                              <div class="row align-items-center">
                                <div class="col-auto">
                                  <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                    <i class="ni ni-chart-pie-35"></i>
                                  </div>
                                </div>
                                <div class="col ml--2">
                                  <h4 class="mb-0">
                                    <a href="{{ url('/astra/reviewer-assignments') }}">Reviewer Assignments</a>
                                  </h4>
                                  <small>Matrix reviewer dan reviewee</small>
                                </div>
                              </div>
                            </div>
                            <div class="list-group-item px-0">
                              <div class="row align-items-center">
                                <div class="col-auto">
                                  <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                    <i class="ni ni-books"></i>
                                  </div>
                                </div>
                                <div class="col ml--2">
                                  <h4 class="mb-0">
                                    <a href="{{ url('/astra/assessment-data') }}">Assessment Data</a>
                                  </h4>
                                  <small>Lihat data assessment</small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Peserta Tab -->
                <div class="tab-pane fade" id="tabs-peserta" role="tabpanel" aria-labelledby="tabs-peserta-tab">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="mb-0">Data Peserta Astra</h3>
                    </div>
                    <div class="table-responsive">
                      <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $peserta = \App\Models\Peserta::all(); @endphp
                          @foreach($peserta as $index => $item)
                          <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td class="text-right">
                              <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown">
                                  <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                  <a class="dropdown-item" href="{{ url('/astra/peserta/' . $item->id) }}">Detail</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      @include('dashboard.layouts._footer')
    </div>

<script>
function showTab(tabId) {
  // Remove active class from all tabs
  document.querySelectorAll('.nav-link').forEach(tab => {
    tab.classList.remove('active');
    tab.setAttribute('aria-selected', 'false');
  });
  
  // Remove show active from all tab panes
  document.querySelectorAll('.tab-pane').forEach(pane => {
    pane.classList.remove('show', 'active');
  });
  
  // Add active to clicked tab
  document.getElementById(tabId).classList.add('active');
  document.getElementById(tabId).setAttribute('aria-selected', 'true');
  
  // Show corresponding tab pane
  const targetPane = document.getElementById(tabId.replace('-tab', ''));
  targetPane.classList.add('show', 'active');
}

function showTabFromSidebar(tabId) {
  // Same functionality as showTab, just called from sidebar
  showTab(tabId);
}
</script>
@endsection