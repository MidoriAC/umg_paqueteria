<div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <div class="scroll-sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('../static/img/user.png') }}" class="img-fluid rounded-circle" alt="User Image" style="width: 50px;">
                </div>
                <div class="info ml-3">
                    <a href="#" class="d-block h5">{{ Auth::user()->name }}, {{ Auth::user()->lastname }}</a>
                    @if(Auth::user()->role == 1 )
                        <button class="btn btn-info btn-sm mt-1">Personal</button>
                    @elseif(Auth::user()->role == 0 )
                        <button class="btn btn-success btn-sm mt-1">Administrador</button>
                    @else 
                        <button class="btn btn-success btn-sm mt-1">Usuario Visitante</button>
                    @endif
                </div>
            </div>
        </div>
        <ul id="sidebarnav">
            @if(kvfj(Auth::user()->permissions,'dashboard'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin')}}" aria-expanded="false">
                    <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span>
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions,'sucursales'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/sucursales')}}" aria-expanded="false">
                    <i class="fas fa-store-alt"></i><span class="hide-menu">Sucursales</span>
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions,'vehiculos'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/vehiculos')}}" aria-expanded="false">
                    <i class="fas fa-truck-moving"></i><span class="hide-menu">Vehículos</span>
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions,'envios'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/envios')}}" aria-expanded="false">
                    <i class="fas fa-map-marker-alt"></i><span class="hide-menu">Envíos</span>
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions,'recepcion'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/recepcion')}}" aria-expanded="false">
                    <i class="fas fa-concierge-bell"></i><span class="hide-menu">Recepción</span>
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions,'ventas'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/ventas')}}" aria-expanded="false">
                    <i class="fas fa-cash-register"></i><span class="hide-menu">Ventas</span>
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions,'reclamos'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/reclamos')}}" aria-expanded="false">
                    <i class="fas fa-hammer"></i><span class="hide-menu">Reclamos</span>
                </a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions,'user_list'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/user')}}" aria-expanded="false">
                    <i class="fas fa-users"></i><span class="hide-menu">Usuarios</span>
                </a>
            </li>
            @endif
            <!-- @if(kvfj(Auth::user()->permissions,'anuncios'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/anuncios')}}" aria-expanded="false">
                    <i class="mdi mdi-file"></i><span class="hide-menu">Anuncios</span>
                </a>
            </li>
            @endif -->
            @if(kvfj(Auth::user()->permissions,'auditoria'))
            <li class="sidebar-item"> 
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin/acciones')}}" aria-expanded="false">
                    <i class="fas fa-user-shield"></i><span class="hide-menu">Auditoria</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>