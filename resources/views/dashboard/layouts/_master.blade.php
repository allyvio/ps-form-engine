<!DOCTYPE html>
<html>

@include('dashboard.layouts._header')

<body>
  <!-- Sidenav -->
  @include('dashboard.layouts._sidebar')
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Button trigger modal -->

    <!-- Modal -->
    @yield('modal')
    <!-- Topnav -->
    @include('dashboard.layouts._topbar')
    @yield('content')
  </div>
  
  <!-- Argon Scripts -->
  <!-- Core -->
  @include('dashboard.layouts._script')
</body>

</html>