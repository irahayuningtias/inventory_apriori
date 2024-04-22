<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset ('assets/image/logo-hari-hari.png') }}">
    <title>IMS - Kategori Barang</title>

    <!-- Custom fonts for this template-->
    <link href="{{!! asset('assets/vendor/fontawesome-free/css/all.min.css') !!}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{!! asset('assets/css/app.css') !!}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Custom styles for this page-->
    <link href="{!! asset('assets/css/dataTables.css') !!}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img class="brand-icon" src="{{ asset('assets/image/logo-hari-hari.png') }}" alt="Hari Hari Store" style="height= 50px; width= 50px;">
                </div>
                <div class="sidebar-brand-text mx-3">Hari Hari Store</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Karyawan</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterData" aria-expanded="true" aria-controls="collapseMasterData">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Master Data</span>
                </a>
                <div id="collapseMasterData" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="category">Kategori</a>
                        <a class="collapse-item" href="product">Barang</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePersediaan" aria-expanded="true" aria-controls="collapsePersediaan">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Persediaan</span>
                </a>
                <div id="collapsePersediaan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Arus Persediaan</h6>
                        <a class="collapse-item" href="supply_in">Barang Masuk</a>
                        <a class="collapse-item" href="supply_out">Barang Keluar</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaction">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApriori"
                    aria-expanded="true" aria-controls="collapseApriori">
                    <i class="fas fa-fw fa-sync"></i>
                    <span>Apriori</span>
                </a>
                <div id="collapseApriori" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="apriori/apriori_process">Proses Apriori</a>
                        <a class="collapse-item" href="apriori/apriori_result">Hasil Apriori</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                    aria-expanded="true" aria-controls="collapseLaporan">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseLaporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gudang</h6>
                        <a class="collapse-item" href="#">Laporan Harian</a>
                        <a class="collapse-item" href="#">Laporan Bulanan</a>
                        <h6 class="collapse-header">Apriori</h6>
                        <a class="collapse-item" href="#">Laporan Analisis Apriori</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="account">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Akun</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
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

                <div class="container-fluid">

                    <h7 class="m-0 font-weight-normal "><a href="category">Kategori</a></h7><br><br>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Kategori</h1>
                        <p class="mb-3">Fitur ini berisikan master data kategori barang</p><br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 col">
                            <div class="d-flex justify-content-between align-item-center">
                                <h5 class="m-0 font-weight-bold text-primary text-center">Data Kategori</h5>
                                <a href="{{ route('category.create') }}" class="btn btn-primary btn-icon-split ">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-add"></i>
                                    </span>
                                    <span class="text">Tambah Data</span>
                                </a>
                            </div>        
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="dataTable_length">
                                            <form method="GET" action="{{ route('category') }}">
                                            <label for="dataTable_length">Show 
                                                <select name="dataTable_length" id="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="10" {{ request()->input('dataTable_length') == 10 ? 'selected' : '' }}>10</option>
                                                    <option value="25" {{ request()->input('dataTable_length') == 25 ? 'selected' : '' }}>25</option>
                                                    <option value="50" {{ request()->input('dataTable_length') == 50 ? 'selected' : '' }}>50</option>
                                                    <option value="100" {{ request()->input('dataTable_length') == 100 ? 'selected' : '' }}>100</option>
                                                </select> entries
                                            </label>
                                        </div>
                                    </div>
                                    <form action="{{ route('search') }}" method="GET">
                                        <div class="col-sm-12 col-md-6">
                                        <div id="dataTable_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="text" name="search" class="form-control form-control-sm" aria-controls="dataTable" value="{{ old('search') }}">
                                            </label>    
                                        </div>
                                    </div>
                                    </form>
                                </div>

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message}}</p>
                                    </div>
                                @endif

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Kategori</th>
                                            <th>Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $Category)
                                        <tr>
                                            <td>{{ $Category['id_category'] }}</td>
                                            <td>{{ $Category->category_name }}</td>
                                            <td>
                                            <form action="{{ route('category.destroy', $Category->id_category) }}" method="POST">
                                                <a href="{{ route('category.show', $Category->id_category) }}" class="btn btn-info btn-circle btn-sm">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                                <a href="{{ route('category.edit', $Category->id_category) }}" class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-circle btn-sm" onclick="return confirmDelete()">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row justify-content-between">
                                    <div class="mt-2">Showing {{($categories->currentpage()-1)*$categories->perpage()+1}} to {{$categories->currentpage()*$categories->perpage()}}
                                        of  {{$categories->total()}} entries
                                    </div>
                                    <div>{{ $categories->onEachSide(1)->links() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Inventory Management System - Hari Hari Store 2024</span>
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
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script>

    <!-- perlu penambahan cdn -->
    <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    end of perlu penambahan cdn -->

    <!-- Confirm Delete -->
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this item?');
        }
    </script>

</body>

</html>