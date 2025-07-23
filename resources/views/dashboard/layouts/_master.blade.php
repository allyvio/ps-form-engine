<!DOCTYPE html>
<html>

@include('dashboard.layouts._header')

<body>
  <!-- Main content without sidebar -->
  <div class="main-content">
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