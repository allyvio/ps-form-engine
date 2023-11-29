@extends('dashboard.layouts._master')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          @include('dashboard.layouts._breadcrumb')
          <!-- Card stats -->
          <div class="row mb-3">
              <div class="col-6">
                <h3 class="mb-0 text-secondary">{{$data['name']}}</h3>
              </div>
          </div>
          <div class="row">
            @foreach($package as $item)
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <a href="{{url('assesment/detail/'.$item->id.'/package')}}">
                        <h5 class="card-title text-uppercase text-muted mb-0">{{$item->name}}</h5>
                      </a>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 0</span>
                    <span class="text-nowrap">Peserta mengerjakan</span>
                  </p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->

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
                <label for="exampleFormControlTextarea1">Soal</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Pilihan A</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Pilihan B</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Pilihan C</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Pilihan D</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-control">
                <label>Jawaban benar : </label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="customRadioInline" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1">A</label>
                    </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">B</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">C</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">D</label>
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

<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{url('assesment/edit/project')}}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="editProjectModalLabel">Lengkapi data project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label for="name">Nama project</label>
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

<div class="modal fade" id="createPackageModal" tabindex="-1" aria-labelledby="createPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{url('assesment/create/package')}}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="createPackageModalLabel">Lengkapi data paket</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label for="name">Nama paket</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name" required>
                <input type="hidden" class="form-control" id="project_id" aria-describedby="nameHelp" name="project_id" value="{{$data['id']}}">
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