<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
                <img height="30" src="{{ asset('img/logo-leos.png')}}" class="header-brand-img" title="RADMIN">
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}">
                        <span>לוח בקרה</span>
                        <i class="ik ik-bar-chart-2"></i>
                    </a>
                </div>
                <div
                    class="nav-item {{ ($segment1 == 'clients') ? 'active open' : '' }} has-sub">
                    <a href="#">
                        <span>לקוחות</span>
                        <i class="ik ik-user"></i>
                    </a>
                    <div class="submenu-content">
                        @can('manage_client')
                            <a href="{{url('clients/add-client')}}"
                               class="menu-item {{ ($segment1 == 'add-client') ? 'active' : '' }}">הוסף לקוח חדש</a>
                        @endcan
                        @can('view_client_data')
                            <a href="{{url('clients/index')}}"
                               class="menu-item {{ ($segment1 == 'index') ? 'active' : '' }}">רשימת לקוחות</a>
                        @endcan
                    </div>
                </div>

                <div
                    class="nav-item {{ ($segment1 == 'products') ? 'active open' : '' }} has-sub">
                    <a href="#">
                        <span>מוצרים</span>
                        <i class="ik ik-briefcase"></i>
                    </a>
                    <div class="submenu-content">
                        @can('manage_product')
                            <a href="{{ URL::route('product.create') }}"
                               class="menu-item {{ ($segment1 == 'create-product') ? 'active' : '' }}">הוסף מוצר חדש</a>
                        @endcan
                        @can('view_client_data')
                            <a href="{{url('clients/index')}}"
                               class="menu-item {{ ($segment1 == 'index') ? 'active' : '' }}">רשימת לקוחות</a>
                        @endcan
                    </div>
                </div>


                <div
                    class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#">
                        <span>מנהל מערכת</span>
                        <i class="ik ik-user"></i>
                    </a>
                    <div class="submenu-content">
                        @can('manage_user')
                            <a href="{{url('users')}}"
                               class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">משתשמים</a>
                            <a href="{{url('user/create')}}"
                               class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">משתמש
                                חדש</a>
                        @endcan
                        @can('manage_roles')
                            <a href="{{url('roles')}}"
                               class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">תפקידים</a>
                        @endcan
                        @can('manage_permission')
                            <a href="{{url('permission')}}"
                               class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">הרשאות</a>
                        @endcan
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
