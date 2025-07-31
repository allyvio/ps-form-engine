@extends('astra.layouts._master')

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
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Peserta</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $totalPeserta ?? 0 }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-single-02"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-info mr-2"><i class="ni ni-circle-08"></i></span>
                    <span class="text-nowrap">Jumlah karyawan terdaftar</span>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Assessments</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $totalAssessments ?? 0 }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="ni ni-collection"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="ni ni-chart-pie-35"></i></span>
                    <span class="text-nowrap">Penilaian yang telah dilakukan</span>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Reviewers</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $totalReviewers ?? 0 }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-support-16"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-warning mr-2"><i class="ni ni-bullet-list-67"></i></span>
                    <span class="text-nowrap">Penilai yang terlibat</span>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Completed Reports</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $completedAssessments ?? 0 }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="ni ni-check-bold"></i></span>
                    <span class="text-nowrap">Laporan gap analysis selesai</span>
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
              <h3 class="mb-0">Daftar Peserta Assessment - Gap Analysis</h3>
              <p class="text-muted mb-0">Klik tombol "Gap Analysis" untuk melihat perhitungan gap competency dari database</p>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">No.</th>
                    <th scope="col" class="sort" data-sort="budget">Name</th>
                    <th scope="col" class="sort" data-sort="status">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody class="list">
                @foreach($data as $index => $item)
                  <tr>
                    <td>
                    <span class="text-muted">{{$index+1}}</span>
                    </td>
                    <td class="budget">
                        {{$item->name}}
                    </td>
                    <td>
                    <span class="text-muted">{{$item->email}}</span>
                    </td>
                    <td>
                    @php
                        $statusText = $item->gap_status ?? 'Belum Dinilai';
                        $percentage = $item->gap_percentage ?? 0;
                        
                        // Determine badge class based on status
                        switch ($statusText) {
                            case 'Memenuhi Kriteria':
                                $badgeClass = 'badge-success';
                                break;
                            case 'Cukup Memenuhi':
                                $badgeClass = 'badge-info';
                                break;
                            case 'Kurang Memenuhi':
                                $badgeClass = 'badge-warning';
                                break;
                            case 'Belum Memenuhi':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-secondary';
                                break;
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }}" title="{{ $percentage }}% kompeten">
                        {{ $statusText }}
                    </span>
                    </td>
                    <td class="text-right">
                      <a href="{{ url('astra/peserta/' . $item->id) }}" class="btn btn-sm btn-primary" title="Lihat Gap Analysis">
                        <i class="fas fa-chart-line"></i> Gap Analysis
                      </a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
          </div>
        </div>
      </div>
      <!-- Footer -->
    @include('dashboard.layouts._footer')
    </div>
@endsection