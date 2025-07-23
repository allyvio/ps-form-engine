<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{url('/admin')}}">
          <img src="{{asset('dashboard/img/brand/blue.png')}}" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="#navbar-components" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-components">
                <i class="ni ni-ui-04 text-info"></i>
                <span class="nav-link-text">Upload data</span>
              </a>
              <div class="collapse show" id="navbar-components">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{url('admin/astra/upload-data')}}" class="nav-link">Riwayat upload data</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-peserta" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-peserta">
                <i class="ni ni-single-02 text-info"></i>
                <span class="nav-link-text">Peserta</span>
              </a>
              <div class="collapse" id="navbar-peserta">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{url('/admin/astra/peserta')}}" class="nav-link">Dafter Peserta</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-reports" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-reports">
                <i class="ni ni-single-copy-04 text-pink"></i>
                <span class="nav-link-text">Asesmen Report</span>
              </a>
              <div class="collapse" id="navbar-reports">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="../../pages/forms/elements.html" class="nav-link">Elements</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/forms/components.html" class="nav-link">Components</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/forms/validation.html" class="nav-link">Validation</a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
        </div>
      </div>
    </div>
  </nav>