<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{$title ?? 'Dashboard'}}</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('assets/favicon.jpg')}}">


</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
{{--            <div class="sidebar-brand-icon rotate-n-15">--}}
{{--                <i class="fas fa-laugh-wink"></i>--}}
{{--            </div>--}}
{{--            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>--}}
            <img src="{{asset('assets/logo.png')}}" alt="" style="width: 100%; height: auto;">
        </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'bg-white' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt {{ request()->routeIs('dashboard') ? 'text-dark' : 'text-white' }}"></i>
                <span class="{{ request()->routeIs('dashboard') ? 'text-dark' : 'text-white' }}">Dashboard</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ request()->routeIs('image.index') || request()->routeIs('images.show') ? 'bg-white' : '' }}">
            <a class="nav-link" href="{{ route('image.index') }}" aria-expanded="true">
                <i class="fas fa-images {{ request()->routeIs('image.index') || request()->routeIs('images.show') ? 'text-dark' : 'text-white' }}"></i>
                <span class="{{ request()->routeIs('image.index') || request()->routeIs('images.show') ? 'text-dark' : 'text-white' }}">Images</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        @if(auth()->user()->role == 'admin')
            <li class="nav-item {{ request()->routeIs('images.upload') ? 'bg-white' : '' }}">
                <a class="nav-link" href="{{route('images.upload')}}"
                   aria-expanded="true" >
                    <i class="fas fa-upload {{ request()->routeIs('images.upload') ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ request()->routeIs('images.upload') ? 'text-dark' : 'text-white' }}">Upload</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ (request()->routeIs('customer.index') || request()->routeIs('customer.edit') || request()->routeIs('customer.create') || request()->routeIs('customer.images') ) ? 'bg-white' : '' }}">
                <a class="nav-link" href="{{route('customer.index')}}"
                   aria-expanded="true" >
                    <i class="fas fa-user-friends {{ (request()->routeIs('customer.index') || request()->routeIs('customer.edit') || request()->routeIs('customer.create') || request()->routeIs('customer.images')) ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ (request()->routeIs('customer.index') || request()->routeIs('customer.edit') || request()->routeIs('customer.create') || request()->routeIs('customer.images') ) ? 'text-dark' : 'text-white' }}">Customers</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->routeIs('customer.failed.all') ) ? 'bg-white' : '' }}">
                <a class="nav-link" href="{{route('customer.failed.all')}}"
                   aria-expanded="true" >
                    <i class="fas fa-user-friends {{ (request()->routeIs('customer.failed.all') ) ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ (request()->routeIs('customer.failed.all') ) ? 'text-dark' : 'text-white' }}">Not Existing Customers</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->routeIs('category.index') || request()->routeIs('category.create') || request()->routeIs('category.edit') ) ? 'bg-white' : 'text' }}">
                <a class="nav-link" href="{{route('category.index')}}"
                   aria-expanded="true" >
                    <i class="fas fa-stream {{ (request()->routeIs('category.index') || request()->routeIs('category.create') ||request()->routeIs('category.edit') ) ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ (request()->routeIs('category.index') || request()->routeIs('category.create') ||request()->routeIs('category.edit') ) ? 'text-dark' : 'text-white' }}">Category</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->routeIs('package.index') || request()->routeIs('package.create'))  ? 'bg-white' : 'text' }}">
                <a class="nav-link" href="{{route('package.index')}}"
                   aria-expanded="true">
                    <i class="fas fa-language {{ (request()->routeIs('package.index') || request()->routeIs('package.create')) ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ (request()->routeIs('package.index') || request()->routeIs('package.create'))  ? 'text-dark' : 'text-white' }}">Package</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ (request()->routeIs('language.index') || request()->routeIs('language.create'))  ? 'bg-white' : 'text' }}">
                <a class="nav-link" href="{{route('language.index')}}"
                   aria-expanded="true" >
                    <i class="fas fa-language {{ (request()->routeIs('language.create') || request()->routeIs('language.index')) ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ (request()->routeIs('language.create') || request()->routeIs('language.index'))  ? 'text-dark' : 'text-white' }}">Language</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">



            <li class="nav-item {{ request()->routeIs('downloads.view')  ? 'bg-white' : 'text' }}">
                <a class="nav-link" href="{{route('downloads.view')}}"
                   aria-expanded="true" >
                    <i class="fas fa-download {{ request()->routeIs('downloads.view') ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ request()->routeIs('downloads.view')  ? 'text-dark' : 'text-white' }}">Downloads</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->routeIs('visits')  ? 'bg-white' : 'text' }}">
                <a class="nav-link" href="{{route('visits')}}"
                   aria-expanded="true" >
                    <i class="fas fa-signal {{ request()->routeIs('visits') ? 'text-dark' : 'text-white' }}"></i>
                    <span class="{{ request()->routeIs('visits')  ? 'text-dark' : 'text-white' }}">Web Traffic</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">


        @endif

        <li class="nav-item">
            <a class="nav-link btn btn-danger" href="{{route('logout')}}"
               aria-expanded="true" >
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider mb-4">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                             aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                           placeholder="Search for..." aria-label="Search"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>


                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                            <img class="img-profile rounded-circle" alt="profile"
                                 src="{{asset('assets/profile.png')}}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{route('profile')}}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show right-0 top-0" role="alert">
                    <strong>Success!</strong> {{session('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show right-0 top-0" role="alert" style="z-index: 999;">
                    <strong>Error!</strong> {{session('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Real Victory Groups</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{route('logout')}}">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
{{--<script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>--}}

<!-- Page level custom scripts -->
<script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>
{{--<script src="{{asset('assets/js/demo/chart-pie-demo.js')}}"></script>--}}

</body>

</html>
