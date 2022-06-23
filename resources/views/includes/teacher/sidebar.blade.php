<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('teacher.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Notices
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.classes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Classes
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('login.logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
