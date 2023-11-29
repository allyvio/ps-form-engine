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
              <a class="nav-link" href="#navbar-dashboard" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-dashboard">
                <i class="ni ni-ungroup text-orange"></i>
                <span class="nav-link-text">Manajemen Kuis</span>
              </a>
              <div class="collapse" id="navbar-dashboard">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{url('/assesment/create')}}" class="nav-link">Buat Kuis</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/login.html" class="nav-link">Login</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/register.html" class="nav-link">Register</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/lock.html" class="nav-link">Lock</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/timeline.html" class="nav-link">Timeline</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/profile.html" class="nav-link">Profile</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-ungroup text-orange"></i>
                <span class="nav-link-text">Data siswa</span>
              </a>
              <div class="collapse" id="navbar-examples">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="../../pages/examples/pricing.html" class="nav-link">Semua siswa</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/login.html" class="nav-link">Login</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/register.html" class="nav-link">Register</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/lock.html" class="nav-link">Lock</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/timeline.html" class="nav-link">Timeline</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/examples/profile.html" class="nav-link">Profile</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-components">
                <i class="ni ni-ui-04 text-info"></i>
                <span class="nav-link-text">Data Kelas</span>
              </a>
              <div class="collapse" id="navbar-components">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="../../pages/components/buttons.html" class="nav-link">Buttons</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/components/cards.html" class="nav-link">Cards</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/components/grid.html" class="nav-link">Grid</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/components/notifications.html" class="nav-link">Notifications</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/components/icons.html" class="nav-link">Icons</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/components/typography.html" class="nav-link">Typography</a>
                  </li>
                  <li class="nav-item">
                    <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-multilevel">Multi level</a>
                    <div class="collapse show" id="navbar-multilevel">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="#!" class="nav-link ">Third level menu</a>
                        </li>
                        <li class="nav-item">
                          <a href="#!" class="nav-link ">Just another link</a>
                        </li>
                        <li class="nav-item">
                          <a href="#!" class="nav-link ">One last link</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
                <i class="ni ni-single-copy-04 text-pink"></i>
                <span class="nav-link-text">Data Report</span>
              </a>
              <div class="collapse" id="navbar-forms">
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
            <li class="nav-item">
              <a class="nav-link" href="#navbar-tables" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-tables">
                <i class="ni ni-align-left-2 text-default"></i>
                <span class="nav-link-text">Tables</span>
              </a>
              <div class="collapse" id="navbar-tables">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="../../pages/tables/tables.html" class="nav-link">Tables</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/tables/sortable.html" class="nav-link">Sortable</a>
                  </li>
                  <li class="nav-item">
                    <a href="../../pages/tables/datatables.html" class="nav-link">Datatables</a>
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