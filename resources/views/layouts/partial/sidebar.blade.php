<aside class="main-sidebar elevation-4 sidebar-dark-info" >
    <!--Logo -->
   
    <a href="{{url('/')}}" class="brand-link navbar-info text-sm">
    <img src="{{asset('img/signo_pesos.png')}}" alt="TúCrédito Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">TúCrédito</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="{{route('perfil.index')}}" class="d_block">{{auth()->user()->nombre}}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @hasrole('SuperUser|Prestamista|Administrador|Cobrador')  
            <li class="nav-item ">
              <a href="{{route('credito.index')}}" class="nav-link {{request()->routeIs('credito.index') ? 'active' : ''}}">
                <i class="nav-icon fas fa-money-check-alt"></i>
                <p>
                  Creditos
                </p>
              </a>
          </li>
          @endhasrole
          @hasrole('SuperUser|Prestamista|Administrador')
          <li class="nav-item">
            <a href="{{route('cliente.index')}}" class="nav-link {{request()->routeIs('cliente.index') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          
          <li class="nav-item">
          <a href="{{route('cobradores.index')}}" class="nav-link {{request()->routeIs('cobradores.index') ? 'active' : ''}}">
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
          @endhasrole
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
                <a href="{{route('cancelacion')}}" class="nav-link">
                  <i class="far fa-window-close nav-icon"></i>
                  <p>Cancelar Recibo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('deudores')}}" class="nav-link">
                  <i class="fas fa-user-tag nav-icon"></i>
                  <p>Deudores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('bolsa')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>BOLSA</p>
                </a>
              </li>
            </ul>
          </li>
          @hasrole('SuperUser|Prestamista|Administrador')
          <li class="nav-item">
          <a href="{{route('allsettings')}}" class="nav-link {{request()->routeIs('allsettings') ? 'active' : ''}}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuraciones
              </p>
            </a>
          </li>
          <!--
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
              </li>-->
              @endhasrole
            </ul>
          </li>
            

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>