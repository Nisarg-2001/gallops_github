<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="#" class="brand-link bg-white" style="height:65px;">
        <span class=" ml-5 brand-text text-dark font-weight-bold fixed">GALLOPS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"  role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            User Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/user') }}" class="nav-link ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/tax') }}" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Taxes

                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/category') }}" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            Categories

                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/subCategory') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-ul"></i>
                        <p>
                            Sub Categories

                        </p>
                    </a>
                </li>
                <li class="nav-item menu">
                    <a href="{{ url('/products') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Products

                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/vendors') }}" class="nav-link">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            Vendors

                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/assign_product') }}" class="nav-link ">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            Assign Products
                        </p>
                    </a>
                </li>


                <li class="nav-item menu">
                    <a href="{{ url('/order') }}" class="nav-link ">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/admin-order') }}" class="nav-link ">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Admin Orders
                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/vendor-order') }}" class="nav-link ">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Vendor Orders
                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/inward') }}" class="nav-link">
                        <i class="nav-icon fas fa-dolly"></i>
                        <p>
                            Inwards

                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/outward') }}" class="nav-link">
                        <i class="nav-icon fas fa-dolly"></i>
                        <p>
                            Outwards

                        </p>
                    </a>
                </li>

                <li class="nav-item menu">
                    <a href="{{ url('/orders') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Returned Goods

                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>