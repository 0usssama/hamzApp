
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Hamza App</title>

    <link rel="stylesheet" href="/css/app.css">
    
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
    
      <!-- Notifications Dropdown Menu -->
    
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Hamza App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
          <li class="nav-item">
          
             
             
              <router-link to="/dashboard" class="nav-link" id="dashBoard"> <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
              </router-link>
            </li>
          <li class="nav-item ">

              <router-link to="/eleve" class="nav-link expandable"> <i class="nav-icon fas fa-user-friends"></i>
                <p>
                  Eleves
                </p>
                </router-link>
              </li>
                <li class="nav-item ">

                <router-link to="/mois" class="nav-link expandable"> <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>
                    Mois
                  </p>
                  </router-link>
                  <li class="nav-item ">

                  <router-link to="/payments" class="nav-link expandable"> <i class="nav-icon fas fa-hand-holding-usd"></i>
                    <p>
                      Payements
                    </p>
                    </router-link>
                  </li>
                    <li class="nav-item ">

                    <router-link to="/tests" class="nav-link expandable"> <i class="nav-icon fas fa-chalkboard-teacher"></i>
                      <p>
                        Tests
                      </p>
                      </router-link>
                    </li>
          <li class="nav-item ">

                      <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="nav-link expandable">
              <i class="fa fa-power-off"></i>&nbsp;&nbsp;&nbsp;&nbsp;
             <p>
                se déconnecter
             </p>

            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
       
            </form>
            
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid mt-4">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  <!-- Main Footer -->
  <footer class="main-footer">
   </footer>

  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>

<script>
  
  </script>
</body>
</html>
