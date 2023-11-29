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
                      <h5 class="card-title text-uppercase text-muted mb-0">Total traffic</h5>
                      <span class="h2 font-weight-bold mb-0">350,897</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-active-40"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                      <span class="h2 font-weight-bold mb-0">2,356</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="ni ni-chart-pie-35"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Question</h5>
                      <span class="h2 font-weight-bold mb-0">924</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-money-coins"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                      <span class="h2 font-weight-bold mb-0">49,65%</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
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
      <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <div class="row">
              <div class="col-6">
                <h3 class="mb-0">DATA PROJECT & QUIZ</h3>
              </div>
              <div class="col-6 text-right">
                <button type="button" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="modal" data-target="#createProjectModal">
                <span class="btn-inner--icon"><i class="fas fa-user-edit"></i></span>
                <span class="btn-inner--text">Buat Project</span>
                </button>
              </div>
            </div>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush table-striped">
              <thead class="thead-light">
                <tr>
                  <th>Nomer</th>
                  <th>Nama</th>
                  <th>Waktu mulai</th>
                  <th>Waktu selesai</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $item)
                <tr>
                  <td>
                    <span class="text-muted">{{$loop->index + 1}}</span>
                  </td>
                  <td>
                    <span class="font-weight-bold">{{$item->name}}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{$item->start_time}}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{$item->end_time}}</span>
                  </td>
                  <td class="table-actions">
                    <a href="{{url('/assesment/detail/'.$item->id)}}" class="table-action" data-toggle="tooltip" data-original-title="Edit project">
                      <i class="fas fa-user-edit"></i>
                    </a>
                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Delete product">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
      </div>
    </div>
@endsection

@section('modal')
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{url('assesment/create/project')}}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="createProjectModalLabel">Lengkapi data project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label for="name">Nama project</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name" required>
              </div>
              <div class="form-group">
                <label for="startDate">Tangga mulai</label>
                <input type="date" class="form-control" id="startDate" aria-describedby="startDateHelp" name="startDate" required>
                <small id="startDateHelp" class="form-text text-muted"></small>
              </div>
              <div class="form-group">
                <label for="startTime">Waktu mulai</label>
                <input type="time" class="form-control" id="startTime" aria-describedby="startTimeHelp" name="startTime" required>
                <small id="startTimeHelp" class="form-text text-muted"></small>
              </div>
              <div class="form-group">
                <label for="endDate">Tangga selesai</label>
                <input type="date" class="form-control" id="endDate" aria-describedby="endDateHelp" name="endDate" required>
                <small id="endDateHelp" class="form-text text-muted"></small>
              </div>
              <div class="form-group">
                <label for="endTime">Waktu selesai</label>
                <input type="time" class="form-control" id="endTime" aria-describedby="endTimeHelp" name="endTime" required>
                <small id="endTimeHelp" class="form-text text-muted"></small>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection