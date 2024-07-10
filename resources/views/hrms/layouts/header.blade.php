<header class="navbar navbar-fixed-top bg-system">
    <div class="navbar-logo-wrapper bg-system">
        <a class="navbar-logo-text" href="#">
            <b> Cleanpro Attendance</b>
        </a>
        <span id="sidebar_left_toggle" class="glyphicon glyphicon-menu-hamburger"></span>
    </div>

    <ul class="nav navbar-nav navbar-left">
        <li class="hidden-xs">
            <a class="navbar-fullscreen toggle-active" href="#">
                <span class="glyphicon glyphicon-fullscreen"></span>
            </a>
        </li>
    </ul>

    
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs"><name>{{Auth::user()->role}}</name></span>
                <span class="fa fa-caret-down hidden-xs mr15"></span>
                {{-- <img src="@if(Auth::user()->employeeData && Auth::user()->employeeData->photo) {{ URL::asset('userimages/' . Auth::user()->employeeData->photo) }} @else {{ URL::asset('userimages/user_white.jpg') }} @endif" alt="avatar" class="mw55" style="border-radius: 10%; border:1px solid #000000; height: 50px; width: 50px; object-fit: cover;"> --}}
                <img src="@if(Auth::user()->employeeData && Auth::user()->employeeData->photo) {{ URL::asset('userimages/' . Auth::user()->employeeData->photo) }} @else {{ URL::asset('userimages/user_white.jpg') }} @endif" alt="avatar" class="mw55" style="border-radius: 10%; border:1px solid #000000; height: 50px; width: 50px; object-fit: cover;">

            </a>
            <ul class="dropdown-menu" role="menu">
                {{-- @if(Route::getFacadeRoot()->current()->uri() != 'change-password') --}}
                <li>
                    <a href="/change-password">
                    <span class="fa fa-lock pr5"></span> Change Password </a> 
                </li>
                {{-- @endif --}}
                <li>
                    <a href="/logout">
                    <span class="fa fa-power-off pr5"></span> Logout{{Session::forget('class')}}
                    {{Session::forget('message')}} </a>
                </li>
            </ul> 
        </li>
    </ul>    
</header>

<head>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
   
</head>

