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
                      <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
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
                <h3 class="mb-0">{{$data['name']}}</h3>
              </div>
              <div class="col-6 text-right">
                <button type="button" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="modal" data-target="#createSoalModal">
                <span class="btn-inner--icon"><i class="fas fa-user-edit"></i></span>
                <span class="btn-inner--text">Buat Soal</span>
                </button>
                <button type="button" class="btn btn-sm btn-secondary btn-round btn-icon" data-toggle="modal" data-target="#editPackageModal">
                <span class="btn-inner--icon"><i class="fas fa-user-edit"></i></span>
                <span class="btn-inner--text">Edit Paket</span>
                </button>
              </div>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush table-striped">
              <thead class="thead-light">
                <tr>
                  <th>Nomer</th>
                  <th >Pertanyaan</th>
                  <th>Pilihan A</th>
                  <th>Pilihan B</th>
                  <th>Pilihan C</th>
                  <th>Pilihan D</th>
                  <th>Pilihan E</th>
                  <th>Jawaban</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($question as $item)
                <tr>
                  <td>
                    <span class="text-muted">{{$loop->index+1}}</span>
                  </td>
                  <td>
                    <span class="font-weight-bold">{{$item->question}}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{$item->value_a}}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{$item->value_b}}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{$item->value_c}}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{$item->value_d}}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{$item->value_e}}</span>
                  </td>
                  <td>
                    <span class="text-muted text-uppercase">{{$item->value_multiple}}</span>
                  </td>
                  <td class="table-actions">
                    <a href="#" class="table-action" data-toggle="tooltip" data-original-title="Edit project">
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
<div class="modal fade" id="createSoalModal" tabindex="-1" aria-labelledby="createSoalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form method="post" action="{{url('assesment/create/soal')}}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="createSoalModalLabel">Buat Soal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="question">Soal</label>
                <textarea class="form-control" id="question" name="question" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="value_a">Pilihan A</label>
                <textarea class="form-control" id="value_a" name="value_a" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="value_b">Pilihan B</label>
                <textarea class="form-control" id="value_b" name="value_b" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="value_c">Pilihan C</label>
                <textarea class="form-control" id="value_c" name="value_c" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="value_d">Pilihan D</label>
                <textarea class="form-control" id="value_d" name="value_d" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="value_d">Pilihan E</label>
                <textarea class="form-control" id="value_e" name="value_e" rows="3"></textarea>
            </div>
            <div class="form-control">
                <label>Jawaban benar : </label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="value_multiple" class="custom-control-input" value="a">
                    <label class="custom-control-label" for="customRadioInline1">A</label>
                    </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="value_multiple" class="custom-control-input" value="b">
                    <label class="custom-control-label" for="customRadioInline2">B</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline3" name="value_multiple" class="custom-control-input" value="c">
                    <label class="custom-control-label" for="customRadioInline3">C</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline4" name="value_multiple" class="custom-control-input" value="d">
                    <label class="custom-control-label" for="customRadioInline4">D</label>
                    <input type="hidden" name="package_id" value="{{$data['id']}}">
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline5" name="value_multiple" class="custom-control-input" value="e">
                    <label class="custom-control-label" for="customRadioInline5">E</label>
                </div>
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

<div class="modal fade" id="editPackageModal" tabindex="-1" aria-labelledby="editPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{url('assesment/edit/package')}}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="editPackageModalLabel">Lengkapi data paket</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label for="name">Nama paket</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name" required value="{{$data['name']}}">
              </div>
              <div class="form-group">
                <label for="startDate">Tangga mulai</label>
                <input type="date" class="form-control" id="startDate" aria-describedby="startDateHelp" name="startDate" required value="{{$data['start_date']}}">
                <small id="startDateHelp" class="form-text text-muted"></small>
              </div>
              <div class="form-group">
                <label for="startTime">Waktu mulai</label>
                <input type="time" class="form-control" id="startTime" aria-describedby="startTimeHelp" name="startTime" required value="{{$data['start_time']}}">
                <small id="startTimeHelp" class="form-text text-muted"></small>
              </div>
              <div class="form-group">
                <label for="endDate">Tangga selesai</label>
                <input type="date" class="form-control" id="endDate" aria-describedby="endDateHelp" name="endDate" required value="{{$data['end_date']}}">
                <small id="endDateHelp" class="form-text text-muted"></small>
              </div>
              <div class="form-group">
                <label for="endTime">Waktu selesai</label>
                <input type="time" class="form-control" id="endTime" aria-describedby="endTimeHelp" name="endTime" required value="{{$data['end_time']}}">
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