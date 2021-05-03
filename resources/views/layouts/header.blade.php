<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <span class="logo-mini">SIRU<b>S</b></span>
        <span class="logo-lg">SRU <b>Surabaya</b></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php $image = Auth::user()->image; ?>
                @if(!empty($image))
                    <img src="{{ asset('images/profile').'/'.$image }}" class="user-image" alt="User Image">
                @else
                    <img src="{{ asset('images/profile/default-profile.jpg') }}" class="user-image" alt="User Image">
                @endif
                <span class="hidden-xs">{{ Auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                @if(!empty($image))
                    <img src="{{ asset('images/profile').'/'.$image }}" class="img-circle" alt="User Image">
                @else
                    <img src="{{ asset('images/profile/default-profile.jpg') }}" class="img-circle" alt="User Image">
                @endif

                <p>
                    {{ Auth()->user()->name }} <br>
                    @if(!empty(Auth()->user()->getRoleNames()))
                        <small>
                        @foreach(Auth()->user()->getRoleNames() as $role)
                            <u>{{ $role }}</u>&nbsp;
                        @endforeach
                        </small>
                    @endif
                </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                <div class="pull-left">
                    <a href=" {{ route('profile.edit', Auth()->user()->id) }} " class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                    <a href="{{ route('logout')}}" class="btn btn-default btn-flat">Logout</a>
                </div>
                </li>
            </ul>
            </li>
        </ul>
        </div>
    </nav>
</header>
    