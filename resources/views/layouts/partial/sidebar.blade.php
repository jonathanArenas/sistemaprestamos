<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!--Logo -->
   
    <a href="{{url('/')}}" class="brand-link">
      <span class="brand-text font-weight-light">ADMINISTRACIÓN</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a class="">
            <span class="brand-text font-weight-light"></span>
          </a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-check-alt"></i>
                <p>
                  Prestamo
                <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('grupal.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grupal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('mensual.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mensual</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Express</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('cliente.index')}}" class="nav-link {{request()->routeIs('cliente.index') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-shipping-fast"></i>
              <p>
                Cobradores
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('zonas.index')}}" class="nav-link {{request()->routeIs('zonas.index') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Zonas y secciones
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Operaciones
                <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('grupal.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Corte de caja</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('mensual.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Deudores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Otros</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Configuraciones
                <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('catalogo.index')}}" class="nav-link {{request()->routeIs('catalogo.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prestamos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user.index')}}" class="nav-link {{request()->routeIs('user.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('allsettings')}}" class="nav-link {{request()->routeIs('allsettings') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Otros</p>
                </a>
              </li>
            </ul>
          </li>
            

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>