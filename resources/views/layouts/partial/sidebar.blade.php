{{-- Inicia sidebar --}}


<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">ADMINISTRACIÓN</li>               
            <li><a href="{{ url('/') }}">                       
               <i class='fa fa-home'></i><span>INICIO</span></a>
            </li>
            <li class="treeviewn">
              <a href=" "><i class='glyphicon glyphicon-usd'></i><span>PRESTAMO</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{route('grupal.index')}}">Grupal</a></li>
                <li><a href="{{ route('mensual.index')}} ">Mensual</a></li>
                <li><a href="{{route('diario.index')}} ">Diario</a></li>
              </ul>
            </li> 
            
            <li>
              <a href="{{ route('cliente.index') }}"><i class='glyphicon glyphicon-briefcase'></i> <span>Clientes</span></a>
            </li>
            <li>
              <a href="{{ route('grupo.index')}}"><i class='fa fa-slideshare'></i><span>Grupos</span></a>
            </li>
            <li>
              <a href="{{ route('cobradores.index') }}"><i class='fa fa-motorcycle'></i> <span>Cobradores</span></a>
            </li>
            {{--
            <li class="treeviewn">
              <a href="#"><i class='fa fa-database'></i> <span>NORMAL MENU</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="./?view=categories">Opcion 1</a></li>
                <li><a href="./?view=clients">Opcion 2</a></li>
              </ul>
            </li> 
          --}}
          <li class="treeviewn">
              <a href="#"><i class='fa fa-usd'></i> <span>Cortes</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="./?view=categories">Diario</a></li>
                <li><a href="./?view=clients">Semanal</a></li>
              </ul>
            </li> 
            <li class="treeviewn">
              <a href="#"><i class='fa fa-file-text-o'></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="./?view=categories">Usuarios</a></li>
                <li><a href="./?view=clients">Cobradores</a></li>
                <li><a href="./?view=categories">Corte Diario</a></li>
                <li><a href="./?view=clients">Corte Semanal</a></li>
              </ul>
            </li> 
            <li class="treeviewn">
              <a href="#"><i class='fa fa-cog'></i> <span>Administracion</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{route('user.index') }}">Usuarios</a></li>
                <li><a href="{{route('roles.index')}} ">Roles para usuarios</a></li>
                <li><a href="{{route('permiso.index')}} ">Permisos para roles</a></li>
                <li><a href="">Configuracion</a></li>
              </ul>
            </li>              
          </ul><!-- /.sidebar-menu -->
    </section>
        <!-- /.sidebar -->
</aside>
     {{-- Fin sidebar --}}