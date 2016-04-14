<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>s</b>TM</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ config('siakad.nama') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li id="indic-loader" class="pull-left">
                    <a><i class="fa fa-spin fa-spinner"></i> Loading </a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
{{--                        <img src="{{ asset('lte2.3/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">--}}
                        <span class="hidden-xs"><i class="fa fa-user-md"></i> {{ Session::get('username') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('lte/img/user2-160x160.jpg') }}" class="img-circle"
                                 alt="User Image">
                            <p>
                                {{ Session::get('nama') }}
                                <small>{{ Session::get('type') }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">
                                    <i class="fa fa-user"></i>
                                    User</a>
                            </div>
                            <div class="pull-right">
                                <a onclick="return confirm('Yakin untuk logout?');"
                                   href="{{ url('/logout') }}" class="btn btn-default btn-flat">
                                    <i class="fa fa-sign-out"></i>
                                    Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>