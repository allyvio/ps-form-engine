<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{url('/')}}">{{$breadcrumb1}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$breadcrumb2}}</li>
        </ol>
        </nav>
    </div>
    @if($button == true)
    <div class="col-lg-6 col-5 text-right">
        <button type="button" class="btn btn-sm btn-secondary btn-round btn-icon" data-toggle="modal" data-target="#createPackageModal">
            <span class="btn-inner--text">Buat Paket</span>
        </button>
    </div>
    @endif
</div>