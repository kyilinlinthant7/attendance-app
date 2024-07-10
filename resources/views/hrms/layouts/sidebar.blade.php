<!-------------- Sidebar - Author -------------- -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>-->
    <div class="sidebar-widget author-widget">
        <div class="media">
            <a href="/profile" class="media-left">
                <!--<img src="@if(Auth::user()->employeeData->photo) {{ URL::asset('userimages/' . Auth::user()->employeeData->photo) }} @else {{ URL::asset('userimages/user_white.jpg') }} @endif" class="img-responsive" style="border-radius: 10%; border:1px solid #000000; margin-left: 12px; height: 65px; width: 65px; object-fit: cover;">-->
                {{-- <img src="@if(Auth::check() && Auth::user()->employeeData && Auth::user()->employeeData->photo) 
                    {{ URL::asset('userimages/' . Auth::user()->employeeData->photo) }} 
                @else 
                    {{ URL::asset('userimages/user_white.jpg') }} 
                @endif" class="img-responsive" style="border-radius: 10%; border:1px solid #000000; margin-left: 12px; height: 65px; width: 65px; object-fit: cover;"> --}}

                {{-- @endif --}}

                <img src="@if(Auth::check() && Auth::user()->employeeData && Auth::user()->employeeData->photo) 
                    {{ URL::asset('userimages/' . Auth::user()->employeeData->photo) }} 
                @else 
                    {{ URL::asset('userimages/user_white.jpg') }} 
                @endif" class="img-responsive" style="border-radius: 10%; border:1px solid #000000; margin-left: 12px; height: 65px; width: 65px; object-fit: cover;">
            </a>
    
            <div class="media-body">
                <div class="media-author"><a href="/profile">{{Auth::user()->email}}</a></div>
            </div>
        </div>
    </div>

<!-- -------------- Sidebar Menu  -------------- -->
<ul class="nav sidebar-menu scrollable">
    @if(Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isAdmin())
        <li class="active">
            <a href="/dashboard">
                <span class="glyphicon glyphicon-asterisk"></span>
                <span class="sidebar-title">Dashboard</span>
            </a>
        </li>
    @endif
    
    @if(!Auth::user()->isLeader())
        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="glyphicon glyphicon-user"></span>
                <span class="sidebar-title">Employees <span class="caret ml10"></span>
            </a>
            <ul class="nav sub-nav">
                @if(Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrAssistant() || Auth::user()->isAdmin())
                    <li>
                        <a href="{{route('add-employee')}}">
                            <span class="glyphicon glyphicon-tags"></span> Add Employee </a>
                    </li>
                @endif
                
                @if(Auth::user()->isAdmin() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                    <li>
                        <a href="{{route('employee-manager')}}">
                            <span class="glyphicon glyphicon-tags"></span> All Employees List 
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employee-probation')}}">
                            <span class="glyphicon glyphicon-tags"></span> Probations List 
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employee-permanent')}}">
                            <span class="glyphicon glyphicon-tags"></span> Permanents List 
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employee-resign')}}">
                            <span class="glyphicon glyphicon-tags"></span> Resigns List 
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employee-warning')}}">
                            <span class="glyphicon glyphicon-tags"></span> Warnings List 
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employee-terminate')}}">
                            <span class="glyphicon glyphicon-tags"></span> Terminate List 
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employee-dismiss')}}">
                            <span class="glyphicon glyphicon-tags"></span> Dismiss List 
                        </a>
                    </li>
                    <li>
                        <a href="{{route('show-exports')}}">
                            <span class="glyphicon glyphicon-tags"></span> Excel Export Data 
                        </a>
                    </li>
                @endif

                @if(Auth::user()->isAdmin())
                    <li>
                        <a href="{{route('upload-emp')}}">
                            <span class="glyphicon glyphicon-tags"></span> Upload </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    
    
    @if(Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isAdmin())
        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="glyphicon glyphicon-user"></span>
                <span class="sidebar-title">User <span class="caret ml10"></span>
            </a>
            <ul class="nav sub-nav">
                @if(Auth::user()->isHR() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isAdmin())
                    <li>
                        <a href="{{route('add-user')}}">
                            <span class="glyphicon glyphicon-tags"></span> Add User </a>
                    </li>
                @endif
                <li>
                    <a href="{{route('user-list')}}">
                        <span class="glyphicon glyphicon-tags"></span> User Listing </a>
                </li>
            </ul>
        </li>
    @endif    

    @if(!Auth::user()->isLeader())
        <li>
            <a class="accordion-toggle" href="/dashboard">
                <span class="glyphicon glyphicon-gift"></span>
                <span class="sidebar-title">Site
                    <span class="caret ml10"></span>
            </a>
            <ul class="nav sub-nav">
                 @if(Auth::user()->isCpManager() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isAdmin())
                    <li>
                        <a href="{{route('add-project')}}">
                            <span class="glyphicon glyphicon-tags"></span> Add Site </a>
                    </li>
                @endif
                <li>
                    <a href="{{route('list-project')}}">
                        <span class="glyphicon glyphicon-tags"></span> Sites List </a>
                </li>
                 @if(Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isAdmin())
                    <li>
                        <a href="{{route('assign-project')}}">
                            <span class="glyphicon glyphicon-tags"></span> Assign Site</a>
                    </li>
                @endif

                <li>
                    <a href="{{route('project-assignment-listing')}}">
                        <span class="glyphicon glyphicon-tags"></span> Site Assignments List</a>
                </li>
                @if(!Auth::user()->isCpAdmin() && Auth::user()->isAdmin() )
                    <li>
                        <a href="{{route('upload-assignment')}}">
                            <span class="glyphicon glyphicon-tags"></span> Upload Excel </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
       
       
    <li>
        <a class="accordion-toggle" href="/dashboard">
            <span class="glyphicon glyphicon-folder-open"></span>
            <span class="sidebar-title">Leaves<span class="caret ml10"></span>
            
        </a>
        <ul class="nav sub-nav">
            <!--@if(Auth::user()->isLeader() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isAdmin())-->
            <!--    <li>-->
            <!--        <a href="{{route('apply-leave')}}">-->
            <!--            <span class="glyphicon glyphicon-shopping-cart"></span> Apply Leave -->
            <!--        </a>-->
            <!--    </li>-->
            <!--@endif-->
            
            <!--@if(Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrAssistant() || Auth::user()->isAdmin())-->
            <!--    <li>-->
            <!--        <a href="{{route('my-leave-list')}}">-->
            <!--            <span class="glyphicon glyphicon-calendar"></span> Apply Leave List </a>-->
            <!--    </li>-->
            <!--@endif-->
            
            <li>
                <a href="{{route('apply-leave')}}">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Apply Leave 
                </a>
            </li>
        
            <li>
                <a href="{{route('my-leave-list')}}">
                    <span class="glyphicon glyphicon-calendar"></span> Apply Leave List </a>
            </li>

            @if(Auth::user()->isHrOfficerCompen() || Auth::user()->isAdmin())
                <li>
                    <a href="{{route('add-leave-record')}}">
                        <span class="fa fa-clipboard"></span>Add Leave Record </a>
                </li>
            @endif
            
            @if(!Auth::user()->isLeader())
                <li>
                    <a href="{{route('leave-record')}}">
                        <span class="fa fa-clipboard"></span> Leave Record </a>
                </li>
            @endif
        </ul>
    </li>


    
    <li>
        <a class="accordion-toggle" href="#">
            <span class="glyphicon glyphicon-tasks"></span>
            <span class="sidebar-title"> Attendance <span class="caret ml10"></span>
        </a>
        <ul class="nav sub-nav">
            @if(Auth::user()->isAdmin() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                <li>
                    <a href="{{route('show-attendance')}}">
                        <span class="glyphicon glyphicon-book"></span>Attendence List</a>
                </li>
                <li>
                    <a href="{{route('add-attendence')}}">
                        <span class="glyphicon glyphicon-book"></span>Add Attendence</a>
                </li>
            @endif
                
            @if(Auth::user()->isAdmin())
                <li>
                    <a href="">
                        <span class="glyphicon glyphicon-book"></span> Upload Sheets</a>
                </li>
            @endif
        </ul>
    </li>
    
    @if(!Auth::user()->isHrOfficerRecruit() && !Auth::user()->isHrER())
        <li>
            <a class="accordion-toggle" href="#">
                <span class="glyphicon glyphicon-dashboard"></span>
                <span class="sidebar-title"> OverTime <span class="caret ml10"></span>
            </a>
            <ul class="nav sub-nav">
                @if(Auth::user()->isCpAdmin() || Auth::user()->isLeader() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isAdmin())
                    <li>
                        <a href="{{route('add-overtime')}}">
                            <span class="glyphicon glyphicon-book"></span>Add OverTime</a>
                    </li>
                @endif
                
                @if(!Auth::user()->isLeader() && !Auth::user()->isHrOfficerRecruit() && !Auth::user()->isHrER())
                    <li>
                        <a href="{{route('overtime-list')}}">
                            <span class="glyphicon glyphicon-book"></span>OverTime List</a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    
    @if(!Auth::user()->isLeader() && !Auth::user()->isHrER())
        <li>
            <a class="accordion-toggle" href="#">
                <span class="glyphicon glyphicon-sunglasses"></span>
                <span class="sidebar-title"> Part Time Worker <span class="caret ml10"></span>
            </a>
            <ul class="nav sub-nav">
                <li>
                    <a href="{{route('parttime-list')}}">
                        <span class="glyphicon glyphicon-book"></span>PartTime List</a>
                </li>
            </ul>
        </li>
    @endif
</ul>
<!-- -------------- /Sidebar Menu  --------------