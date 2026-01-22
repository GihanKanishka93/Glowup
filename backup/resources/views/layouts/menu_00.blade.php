<!-- need to remove -->
{{-- <li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li> --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}" style="height: 98px">
        {{-- --}}
        <div class="sidebar-brand-icon  text-center">
            <img src="{{ asset('img/challenger-vet-logo-white.png') }}" alt="" width="100px" height="auto" srcset="">
            {{-- <i class="fas fa-stethoscope"></i> --}}
        </div>
        {{-- <div class="sidebar-brand-text mx-3">Challenger Vet</div> --}}
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('billing.create') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-user"></i>
            <span>Pet Management</span>
        </a>
        <div id="collapseOne" class="collapse {{  (request()->is('pet*')) ? 'show' : ''   }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-primary-color py-2 collapse-inner rounded">
                @can('pet-create')    <a class="collapse-item {{ request()->routeIs('pet.create') ? 'active' : '' }}" href="{{ route('pet.create') }}">Register new Pet</a>@endcan
                @can('pet-list')      <a class="collapse-item {{ request()->routeIs('pet.index') ? 'active' : '' }}" href="{{ route('pet.index') }}">Pet List</a> @endcan
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-file-invoice"></i>
            <span>Billing and Payment</span>
        </a>
        <div id="collapseOne" class="collapse {{  (request()->is('billing*')) ? 'show' : ''   }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-primary-color py-2 collapse-inner rounded">
                @can('pet-create')    <a class="collapse-item {{ request()->routeIs('billing.create') ? 'active' : '' }}" href="{{ route('billing.create') }}">New Bill</a>@endcan
                @can('pet-list')      <a class="collapse-item {{ request()->routeIs('billing.index') ? 'active' : '' }}" href="{{ route('billing.index') }}">List Bills</a> @endcan
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-user-md"></i>
            <span>Doctors</span>
        </a>
        <div id="collapseOne" class="collapse {{  (request()->is('doctor*')) ? 'show' : ''   }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-primary-color py-2 collapse-inner rounded">
                @can('doctor-create')    <a class="collapse-item {{ request()->routeIs('doctor.create') ? 'active' : '' }}" href="{{ route('doctor.create') }}">Add Doctor</a>@endcan
                @can('doctor')      <a class="collapse-item {{ request()->routeIs('doctor.index') ? 'active' : '' }}" href="{{ route('doctor.index') }}">List Doctors</a> @endcan
            </div>
        </div>
    </li>


    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </a>
        <div id="collapseTwo" class="collapse {{  (request()->is('settings/*')) ? 'show' : ''   }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-primary-color py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                @can('user-list')       <a class="collapse-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">User Management</a>@endcan
                <!--@can('room-list')       <a class="collapse-item {{ request()->routeIs('room.*') ? 'active' : '' }}" href="{{ route('room.index') }}">Room Management</a> @endcan-->
                <!--@can('item-list')       <a class="collapse-item {{ request()->routeIs('item.*') ? 'active' : '' }}" href="{{ route('item.index') }}">Room Inventory</a> @endcan-->
                @can('role-list')       <a class="collapse-item {{ request()->routeIs('role.*') ? 'active' : '' }}" href="{{ route('role.index') }}">Manage User Role</a> @endcan
                @can('suspend-user-list')   <a class="collapse-item {{ request()->routeIs('users.suspendusers') ? 'active' : '' }}" href="{{ route('users.suspendusers') }}">Deleted User List</a>@endcan
                @can('pet-category')       <a class="collapse-item {{ request()->routeIs('pet-category.*') ? 'active' : '' }}" href="{{ route('pet-category.index') }}">Pet Category</a> @endcan
                @can('pet-breed')       <a class="collapse-item {{ request()->routeIs('pet-breed.*') ? 'active' : '' }}" href="{{ route('pet-breed.index') }}">Pet Breed</a> @endcan

                {{--

                <a class="collapse-item {{ request()->routeIs('patient.create') ? 'active' : '' }}" href="more.php">More</a> --}}
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <center><button class="rounded-circle border-0" id="sidebarToggle"></button></center>
    </div>

</ul>
