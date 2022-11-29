<!-- Brand Logo -->
<a href="{{ url('dashboard') }}" class="brand-link">
    <img src="{{ URL::asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <strong class="brand-text font-weight-light"><b>Administrator</b></strong>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ url('dashboard') }}" class="nav-link">
                <i class="fa fa-tachometer-alt"></i> &nbsp;
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('vendor_basic_registration/manage') }}" class="nav-link">
                <i class="fa fa-folder"></i> &nbsp;
                <p>Vendor Registration</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('user/manage') }}" class="nav-link">
                <i class="fa fa-folder"></i> &nbsp;
                <p>Users</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ url('vendor/manage') }}" class="nav-link">
                <i class="fa fa-folder"></i> &nbsp;
                <p>Vendors</p>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-regular fa-folder"></i> &nbsp;
            <p>
              Vendor
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('vendor/create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('vendor/manage') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage </p>
              </a>
            </li>
          </ul>
        </li> --}}
        <li class="nav-header">MODULES</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-folder" aria-hidden="true"></i> &nbsp;
            <p>
              City
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('city/create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('city/manage') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-folder" aria-hidden="true"></i> &nbsp;
            <p>
              Area
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('area/create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('area/manage') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-folder" aria-hidden="true"></i> &nbsp;
            <p>
              Category
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('category/create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('category/manage') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage </p>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-folder" aria-hidden="true"></i> &nbsp;
            <p>
              Services
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('service/create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('service/manage') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-folder" aria-hidden="true"></i> &nbsp;
            <p>
              Converter
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('language-converter') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Text Converter</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('language-input-translate') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Input Translate</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->