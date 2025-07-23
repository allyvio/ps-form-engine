<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{url('/')}}">
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
              <a class="nav-link" href="{{ url('/') }}">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard Astra</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-astra-assessment" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-astra-assessment">
                <i class="ni ni-badge text-orange"></i>
                <span class="nav-link-text">Astra Assessment</span>
              </a>
              <div class="collapse show" id="navbar-astra-assessment">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-peserta-tab')" class="nav-link">Peserta Astra</a>
                  </li>
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-upload-tab')" class="nav-link">Upload Data Astra</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-astra-competency" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-astra-competency">
                <i class="ni ni-chart-bar-32 text-success"></i>
                <span class="nav-link-text">Astra Competency</span>
              </a>
              <div class="collapse" id="navbar-astra-competency">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-reports-tab')" class="nav-link">Matrix Kompetensi Astra</a>
                  </li>
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-reports-tab')" class="nav-link">Gap Analysis Astra</a>
                  </li>
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-reports-tab')" class="nav-link">Level Assessment Astra</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-astra-reports" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-astra-reports">
                <i class="ni ni-books text-info"></i>
                <span class="nav-link-text">Astra Reports</span>
              </a>
              <div class="collapse" id="navbar-astra-reports">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-reports-tab')" class="nav-link">Laporan Individual Astra</a>
                  </li>
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-reports-tab')" class="nav-link">Laporan Departemen Astra</a>
                  </li>
                  <li class="nav-item">
                    <a href="#" onclick="showTabFromSidebar('tabs-reports-tab')" class="nav-link">Summary Report Astra</a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>