<nav class="main-header navbar navbar-expand navbar-light" style="background-color: #2C3E50 ;">
    <ul class="navbar-nav">
        @auth
            @if (Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard.index') }}" class="nav-link font-weight-regular"
                        style="color: #ECF0F1">Dashboard</a>
                </li>
            @else
                <div class="relative w-full">
                    <form method="GET" action="{{ route('home.index') }}" class="relative w-full">
                        <input type="text" name="type_room" value="{{ request('type_room') }}"
                            class="form-input px-4 py-2 rounded-full w-full bg-white text-gray-800 shadow-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 ease-in-out"
                            placeholder="Search...">
                        <i
                            class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 transition-all duration-300 ease-in-out"></i>
                    </form>
                </div>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home.index') }}" class="nav-link font-weight-regular"
                        style="color: #ECF0F1">Home</a>
                </li>
            @endif
        @endauth

        @guest
            <div class="relative w-full">
                <form method="GET" action="{{ route('home.index') }}" class="relative w-full">
                    <input type="text" name="type_room" value="{{ request('type_room') }}"
                        class="form-input px-4 py-2 rounded-full w-full bg-white text-gray-800 shadow-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 ease-in-out"
                        placeholder="Search...">
                    <i
                        class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 transition-all duration-300 ease-in-out"></i>
                </form>
            </div>
        @endguest
    </ul>

    <ul class="navbar-nav ml-auto">
        @auth
            <li class="relative" x-data="{ open: false }">
                <a @click="open = !open" href="#"
                    class="flex items-center text-white hover:text-gray-200 transition duration-200 ease-in-out">
                    <i class="far fa-user text-lg"></i>
                    <span class="ml-2 hidden md:inline">{{ Auth::user()->name }}</span>
                    <i class="fas fa-caret-down ml-2 text-sm"></i>
                </a>

                <div x-show="open" @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200 transform opacity-0 scale-95"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150 transform opacity-100 scale-100"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden border z-50">

                    <div class="px-4 py-3 border-b">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-gray-700 text-center hover:bg-gray-100">
                            Profile
                        </a>
                    </div>

                    @if (Auth::user()->role !== 'admin')
                        <div class="px-4 py-3 border-b">
                            <a href="{{ route('reservations.user') }}"
                                class="block px-4 py-2 text-gray-700 text-center hover:bg-gray-100">
                                Reservations
                            </a>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        @endauth

        @guest
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link text-white font-weight-regular">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </li>
        @endguest
    </ul>
</nav>
