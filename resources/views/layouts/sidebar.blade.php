<aside class="main-sidebar sidebar elevation-4" style="background-color: #2C3E50 ;">
    <a href="#" class="brand-link text-center">
        <span class="brand-text font-weight-bold text-center" style="color: #E8E8E8">LSP</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('dashboard.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt" style="color: #E8E8E8;"></i>
                        <p style="color: #E8E8E8">Dashboard</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt" style="color: #E8E8E8"></i>
                        <p style="color: #E8E8E8">
                            Room Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('room.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon" style="color: #E8E8E8"></i>
                                <p style="color: #E8E8E8">Room List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('room.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon" style="color: #E8E8E8"></i>
                                <p style="color: #E8E8E8">Create Room</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list" style="color: #E8E8E8"></i>
                        <p style="color: #E8E8E8">
                            Type_Rooms
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('type-room.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon" style="color: #E8E8E8"></i>
                                <p style="color: #E8E8E8">List Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('type-room.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon" style="color: #E8E8E8"></i>
                                <p style="color: #E8E8E8">Add Type Rooms</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reservations.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart" style="color: #E8E8E8"></i>
                        <p style="color: #E8E8E8">Reservation</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user-management.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users" style="color: #E8E8E8"></i>
                        <p style="color: #E8E8E8">User Management</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
