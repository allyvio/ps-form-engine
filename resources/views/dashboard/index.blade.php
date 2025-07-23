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
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Astra Peserta</h5>
                      <span class="h2 font-weight-bold mb-0">{{ \App\Models\Peserta::count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-single-02"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">Total karyawan Astra terdaftar</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Astra Departments</h5>
                      <span class="h2 font-weight-bold mb-0">{{ \App\Models\Peserta::distinct('departemen')->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="ni ni-circle-08"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">Jumlah departemen Astra</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Astra Assessment</h5>
                      <span class="h2 font-weight-bold mb-0">{{ \App\Models\FormOtherAstra::count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-paper-diploma"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">Form assessment Astra terisi</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Astra Raters</h5>
                      <span class="h2 font-weight-bold mb-0">{{ \App\Models\FormOtherAstra::distinct('name_id')->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-folder-17"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-muted">Penilai dalam assessment Astra</span>
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
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" id="tabs-reports-tab" data-toggle="tab" href="#tabs-reports" role="tab" aria-controls="tabs-reports" aria-selected="false">
                    <i class="ni ni-books mr-2"></i>Reports
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
                              <h3 class="mb-0">Karyawan Astra per Departemen</h3>
                            </div>
                          </div>
                        </div>
                        <div class="table-responsive">
                          <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">Departemen</th>
                                <th scope="col">Jumlah Peserta</th>
                                <th scope="col">Persentase</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php
                                $departemen = \App\Models\Peserta::selectRaw('departemen, count(*) as total')
                                    ->groupBy('departemen')
                                    ->orderBy('total', 'desc')
                                    ->get();
                                $totalPeserta = \App\Models\Peserta::count();
                              @endphp
                              @foreach($departemen as $dept)
                              <tr>
                                <th scope="row">{{ $dept->departemen }}</th>
                                <td>{{ $dept->total }}</td>
                                <td>
                                  <div class="d-flex align-items-center">
                                    <span class="mr-2">{{ number_format(($dept->total / $totalPeserta) * 100, 1) }}%</span>
                                    <div>
                                      <div class="progress">
                                        <div class="progress-bar bg-gradient-success" role="progressbar" 
                                             style="width: {{ ($dept->total / $totalPeserta) * 100 }}%;"></div>
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
                          <h5 class="h3 mb-0">Astra Quick Actions</h5>
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
                                    <a href="#" onclick="showTab('tabs-peserta-tab')">Peserta Astra</a>
                                  </h4>
                                  <small>Kelola data karyawan Astra</small>
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
                                    <a href="#" onclick="showTab('tabs-reports-tab')">Laporan Astra</a>
                                  </h4>
                                  <small>Lihat dan download laporan</small>
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
                            <th scope="col">Jabatan</th>
                            <th scope="col">Departemen</th>
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
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->departemen }}</td>
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
                
                <!-- Reports Tab -->
                <div class="tab-pane fade" id="tabs-reports" role="tabpanel" aria-labelledby="tabs-reports-tab">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="mb-0">Laporan Assessment Astra</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="card">
                            <div class="card-body text-center">
                              <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow mx-auto mb-3">
                                <i class="ni ni-single-02"></i>
                              </div>
                              <h5 class="card-title">Laporan Individual</h5>
                              <p class="card-text">Download laporan assessment per individu</p>
                              <a href="{{ url('/download-report') }}" class="btn btn-primary">Download</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="card">
                            <div class="card-body text-center">
                              <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow mx-auto mb-3">
                                <i class="ni ni-building"></i>
                              </div>
                              <h5 class="card-title">Laporan Departemen</h5>
                              <p class="card-text">Analisis per departemen Astra</p>
                              <a href="#" class="btn btn-success">Generate</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="card">
                            <div class="card-body text-center">
                              <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow mx-auto mb-3">
                                <i class="ni ni-chart-bar-32"></i>
                              </div>
                              <h5 class="card-title">Summary Report</h5>
                              <p class="card-text">Laporan keseluruhan assessment</p>
                              <a href="#" class="btn btn-info">Generate</a>
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