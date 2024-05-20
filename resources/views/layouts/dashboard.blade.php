@include('layouts.header')


<!-- Navbar -->
@include('layouts.navbar')
  <!-- /.navbar -->

<!-- Main Sidebar Container -->
@include('layouts.sidebar')



  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  

@include('layouts.footer')