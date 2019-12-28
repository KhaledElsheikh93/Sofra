<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | BB</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('adminlte/css/mystyle.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
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
     
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li>
      {!! Form::open(array('url' => '/logout', 'method' => 'POST')) !!}
        <button class='btn btn-primary'>Logout</button>
      {!! Form::close() !!}
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="{{ asset('adminlte/img/AdminLTELogo.png') }}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sofra</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('adminlte/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          <p style="color:white">{{ auth()->user()->name }}</p> 
        </div>
       
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
          <a href="{{  url(route('users.index'))  }}" class="nav-link">
              <i class="	fas fa-user-circle"></i>
              <p>Users</p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{url(route('roles.index')) }}" class="nav-link">
              <i class="fas fa-atlas"></i>
              <p>Roles</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{  url(route('clients.index'))  }}" class="nav-link">
              <i class="fas fa-user-friends"></i>
              <p>Clients</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{  url(route('categories.index'))  }}" class="nav-link">
                  <i class="fas fa-file-alt nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{  url(route('restaurants.index'))}}" class="nav-link">
                  <i class="fas fa-door-open nav-icon"></i>
                  <p>Restaurants</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
          <a href="{{  url(route('products.index'))  }}" class="nav-link">
              <i class="nav-icon fas fa-pizza-slice"></i>
              <p>products</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-globe	"></i>
              <p>
                Cities
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{  url(route('cities.index'))  }}" class="nav-link">
                  <i class="fas fa-landmark nav-icon"></i>
                  <p>Cities</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{  url(route('districts.index'))  }}" class="nav-link">
                  <i class="fas fa-landmark nav-icon"></i>
                  <p>Districts</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{  url(route('orders.index'))  }}" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>Orders</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ url(route('settings.index')) }}" class="nav-link">
              <i class="nav-icon nav-icon fas fa-briefcase"></i>
              <p>Settings</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url(route('payments.index')) }}" class="nav-link">
              <i class="nav-icon nav-icon fas fa-briefcase"></i>
              <p>Payments</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="	fas fa-address-card"></i>
              <p>Contacts</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/users/change-password') }}" class="nav-link">
              <i class="	fas fa-address-card"></i>
              <p>Change password</p>
            </a>
          </li>
          
          <li class="nav-header">MISCELLANEOUS</li>
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.0" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li> -->
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
               @yield('page_title')
               <small>@yield('subject_title')</small>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">@yield('subject_title')</li>
            </ol>
          </div>
        </div>
      </div>
  <!-- /.container-fluid -->
</section>

  @yield('content')
    <!-- Main content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0-rc.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{  asset('adminlte/plugins/jquery/jquery.min.js')  }}"></script>
<!-- Bootstrap 4 -->
<script src="{{  asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')  }}"></script>
<!-- AdminLTE App -->
<script src="{{  asset('adminlte/js/adminlte.min.js')  }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{  asset('adminlte/js/demo.js')  }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

@stack('scripts')
</body>
</html>
