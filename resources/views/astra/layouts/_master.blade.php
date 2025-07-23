<!DOCTYPE html>
<html>

@include('astra.layouts._header')

<body>
  <!-- Sidenav -->
  @include('astra.layouts._sidebar')
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Button trigger modal -->

    <!-- Modal -->
    @yield('modal')
    <!-- Topnav -->
    @include('astra.layouts._topbar')
    @yield('content')
  </div>
  
  <!-- Argon Scripts -->
  <!-- Core -->
  @include('astra.layouts._script')
</body>

</html>