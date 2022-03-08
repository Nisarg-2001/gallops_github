<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="#" class="brand-link bg-white" style="height:80px;">
        <span class=" ml-5 brand-text text-dark font-weight-bold fixed">
            <img src="{{asset('/dist/img/gallops.png')}}" alt="Gallops Logo" class="brand mx-auto my-auto" height="auto" width="90px">
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @if(Auth::check())   @if(Auth::user()->role==1)
                <li class="nav-item ">
                    <a class="nav-link" href="{{ url('dashboard') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Home
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
                    <a href="{{ url('/department') }}" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Departments

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

                <!--<li class="nav-item menu">-->
                <!--    <a href="{{ url('/assign_product') }}" class="nav-link ">-->
                <!--        <i class="nav-icon fas fa-cart-plus"></i>-->
                <!--        <p>-->
                <!--            Assign Products-->
                <!--        </p>-->
                <!--    </a>-->
                <!--</li>-->

                        <li class="nav-item menu">
                        <a href="{{ url('/unit') }}" class="nav-link">
                            <i class="nav-icon fas fa-list-ul"></i>
                            <p>
                                Unit of Measurement
                            </p>
                        </a>
                        </li>

                

               

                


                <li class="nav-item menu">
                    <a  class="nav-link ">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Orders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item menu">
                        <a href="{{ url('/admin-order') }}" class="nav-link ">
                            <i class="nav-icon fas fa-file-edit"></i>
                            <p>
                                Admin Orders
                            </p>
                        </a>
                        </li>

                        <li class="nav-item menu">
                            <a href="{{ url('/vendor-order') }}" class="nav-link ">
                                <i class="nav-icon fas fa-file-edit"></i>
                                <p>
                                    Vendor Orders
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu">
                    <a href="{{url('reports')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-chart-line"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                            <a href="{{url('report/item-master')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Item Master report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('report/raw-stock')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Stock report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('report/stock-ledger')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Stock Ledger report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('report/opening-stock')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Opening Stock report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('report/closing-stock')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Closing Stock report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('report/order')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Order report</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a href="{{url('report/purchase-order')}}" class="nav-link">-->
                        <!--        <i class="far fa-file-invoice nav-icon"></i>-->
                        <!--        <p>Purchase order report</p>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class="nav-item">
                            <a href="{{url('report/inward')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Inward report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('report/outward')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Outward report</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a href="{{url('report/return')}}" class="nav-link">-->
                        <!--        <i class="far fa-file-invoice nav-icon"></i>-->
                        <!--        <p>Return report</p>-->
                        <!--    </a>-->
                        <!--</li>-->
                    </ul>
                </li>

                <!--<li class="nav-item menu">-->
                <!--    <a href="{{ url('/return') }}" class="nav-link">-->
                <!--        <i class="nav-icon fas fa-exchange"></i>-->
                <!--        <p>-->
                <!--            Return Product-->

                <!--        </p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item menu mb-5">-->
                <!--    <a href="{{ url('/expiry') }}" class="nav-link">-->
                <!--        <i class="nav-icon fas fa-user-tag"></i>-->
                <!--        <p>-->
                <!--            Expiry near Products-->
                <!--        </p>-->
                <!--    </a>-->
                <!--</li>-->

                @endif
                @if(Auth::user()->role==2)
                <li class="nav-item menu">
                    <a href="{{ url('/user/dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item menu">
                    <a href="{{ url('/user/order') }}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>
                <li class="nav-item menu">
                    <a href="{{ url('/user/inward') }}" class="nav-link">
                        <i class="nav-icon fas fa-dolly"></i>
                        <p>
                            Inwards
                        </p>
                    </a>
                </li>
                <li class="nav-item menu">
                    <a href="{{ url('/user/outward') }}" class="nav-link">
                        <i class="nav-icon fas fa-dolly"></i>
                        <p>
                            Outwards
                        </p>
                    </a>
                </li>
                <!--<li class="nav-item menu">-->
                <!--    <a href="{{ url('/user/stock') }}" class="nav-link">-->
                <!--        <i class="nav-icon fas fa-dolly"></i>-->
                <!--        <p>-->
                <!--            Add Opening Stock-->
                <!--        </p>-->
                <!--    </a>-->
                <!--</li>-->

                <!--<li class="nav-item menu">-->
                <!--            <a href="{{ url('user/vendor-order') }}" class="nav-link ">-->
                <!--                <i class="nav-icon fas fa-file-edit"></i>-->
                <!--                <p>-->
                <!--                    Purchase Orders-->
                <!--                </p>-->
                <!--            </a>-->
                <!--</li>-->
                <!--<li class="nav-item menu">-->
                <!--    <a href="{{ url('/user/return') }}" class="nav-link">-->
                <!--        <i class="nav-icon fas fa-exchange"></i>-->
                <!--        <p>-->
                <!--            Return Product-->

                <!--        </p>-->
                <!--    </a>-->
                <!--</li>-->

                <li class="nav-item menu">
                    <a href="{{url('user/reports')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-chart-line"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('user/report/order')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Order Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/user/report/opening-stock')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Opening Stock report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/user/report/closing-stock')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Closing Stock report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('user/report/stock-ledger')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Stock Ledger report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('user/report/inward')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Inward Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('user/report/outward')}}" class="nav-link">
                                <i class="far fa-file-invoice nav-icon"></i>
                                <p>Outward Report</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a href="{{url('user/report/return')}}" class="nav-link">-->
                        <!--        <i class="far fa-file-invoice nav-icon"></i>-->
                        <!--        <p>Return Report</p>-->
                        <!--    </a>-->
                        <!--</li>-->
                    </ul>
                </li>
                @endif
                @else

                <!-- VENDORS SIDE-BAR -->
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('vendor/dashboard') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item menu">
                    <a class="nav-link" href="{{ url('vendor/order') }}">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            My Orders
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>