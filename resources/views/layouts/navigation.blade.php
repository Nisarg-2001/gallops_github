<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 fixed-top">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->


                <!-- Navigation Links -->

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:align-right sm:ml-6 ">
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex  text-md font-bold text-gray-700 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div margin-left="200px">{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <ul class="nav nav-pills nav-sidebar flex-column">
                                <li class="nav-item menu">
                                    <a type="button" class="nav-link" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="nav-icon fas fa-key"></i>
                                        <p>
                                            Reset password
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item menu">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();" class="nav-link">
                                        <i class="nav-icon fas fa-sign-out-alt"></i>
                                        <p>
                                            Log Out
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>


            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
@if( session('success'))
              <div class="alert bg-danger alert-dismissible disabled color-pelette" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                {{session('success')}}
              </div>
@endif
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="userForm" action="{{ url('resetpassword') }}">
                    @csrf
                    <div class="col-12">
                        <div class="form-group">
                            <label>Current Password *</label>
                            <input type="hidden" class="form-control" name="id" value="{{ Auth::user()->id }}">
                            <input type="password" class="form-control" name="ctpass" id="title" placeholder="current password" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="pass" id="title" placeholder="new password" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="cnpass" id="title" placeholder="confirm password" required>
                        </div>
                    </div>
                    
                    <input type="submit" class="btn btn-primary" value="Submit">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        
                </form>
            </div>
           
        </div>
    </div>
</div>
<script src="{{ asset('/admin/assets/js/sweetalert.js') }}"></script>
<script src="{{ asset('/admin/assets/js/user/action.js') }}"></script>
