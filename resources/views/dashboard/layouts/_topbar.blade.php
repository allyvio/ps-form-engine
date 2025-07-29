@php use Illuminate\Support\Facades\Auth; @endphp
<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Main Navigation -->
          <ul class="navbar-nav align-items-center">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/') }}">
                <i class="ni ni-tv-2"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/astra/peserta') }}">
                <i class="ni ni-single-02"></i>
                <span class="nav-link-text">Peserta</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/astra/reviewer-assignments') }}">
                <i class="ni ni-chart-pie-35"></i>
                <span class="nav-link-text">Reviewer Assignments</span>
              </a>  
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/astra/assessment-data') }}">
                <i class="ni ni-collection"></i>
                <span class="nav-link-text">Assessment Data</span>
              </a>
            </li>
          </ul>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center ml-md-auto">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center ml-auto ml-md-0">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center">
                    <i class="fas fa-user text-white"></i>
                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name ?? 'User' }}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>