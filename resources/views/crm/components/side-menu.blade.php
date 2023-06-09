<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('crm.home') }}" class="brand-link">
        <img src="{{ asset('crm-assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Cloud Training</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->image_url }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('account.profile') }}" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @if (auth()->user()->role == 'manager')
                    <li class="nav-item">
                        <a href="{{ route('crm.home') }}"
                            class="nav-link {{ request()->routeIs('crm.home') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-chart-network"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->role == 'trainee' || auth()->user()->role == 'advisor')
                    <li class="nav-header">Content</li>
                    <li class="nav-item">
                        <a href="{{ route('myMeetings') }}"
                            class="nav-link {{ request()->routeIs('myMeetings') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                My Meetings
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('myCourses') }}"
                            class="nav-link {{ request()->routeIs('myCourses') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                My Courses
                            </p>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->role == 'trainee')
                    <li class="nav-item">
                        <a href="{{ route('availableCourses') }}"
                            class="nav-link {{ request()->routeIs('availableCourses') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                Available Courses
                            </p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role == 'manager')
                    <li class="nav-header">System Management</li>
                    <li class="nav-item">
                        <a href="{{ route('managers.index') }}"
                            class="nav-link {{ request()->routeIs('managers.index') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                Managers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('advisors.index') }}"
                            class="nav-link {{ request()->routeIs('advisors.index') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                Advisors
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('trainees.index') }}"
                            class="nav-link {{ request()->routeIs('trainees.index') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                Trainees
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('registrations.index') }}"
                            class="nav-link {{ request()->routeIs('registrations.index') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                Trainee Registrations
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('courses.index') }}"
                            class="nav-link {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                Courses
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">Account Management</li>
                <li class="nav-item">
                    <a href="{{ route('account.profile') }}"
                        class="nav-link {{ request()->routeIs('account.profile') ? 'active' : '' }}">
                        <i class="nav-icon fad fa-key"></i>
                        <p>
                            Account Settings
                        </p>
                    </a>
                </li>
                @if (auth()->user()->role == 'trainee')
                    <li class="nav-item">
                        <a href="{{ route('account.accomplishments') }}"
                            class="nav-link {{ request()->routeIs('account.accomplishments') ? 'active' : '' }}">
                            <i class="nav-icon fad fa-key"></i>
                            <p>
                                Accomplishments
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('account.change-password') }}"
                        class="nav-link {{ request()->routeIs('account.change-password') ? 'active' : '' }}">
                        <i class="nav-icon fad fa-key"></i>
                        <p>
                            Change Password
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fad fa-sign-out"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
