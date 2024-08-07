<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="{{ asset('assets/image/logo-hari-hari.png') }}"/>
        <title>IMS - Karyawan</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"/>
        <!-- Custom styles for this template-->
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>

        <!-- Custom styles for this page-->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.css"/>
    </head>

    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
                    <div class="sidebar-brand-icon">
                        <img class="brand-icon" src="{{ asset('assets/image/logo-hari-hari.png') }}" alt="Hari Hari Store" style="height: 50px; width: 50px"/>
                    </div>
                    <div class="sidebar-brand-text mx-3">Hari Hari Store</div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0" />

                <!-- Nav Item -->
                <li class="nav-item">
                    <a class="nav-link" href="dashboard">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="users">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Karyawan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterData" aria-expanded="true" aria-controls="collapseMasterData">
                        <i class="fas fa-fw fa-archive"></i>
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
                        <i class="fas fa-fw fa-archive"></i>
                        <span>Persediaan</span>
                    </a>
                    <div id="collapsePersediaan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="incoming_product">Barang Masuk</a>
                            <a class="collapse-item" href="outcoming_product">Barang Keluar</a>
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
                <a class="nav-link" href="apriori">
                    <i class="fas fa-fw fa-sync"></i>
                    <span>Apriori</span>
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
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="profile">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <!-- End of Topbar -->

                    <div class="container-fluid">
                        <h7 class="m-0 font-weight-normal"><a href="users">Karyawan</a></h7><br /><br />

                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Karyawan</h1>
                        <p class="mb-3">
                            Fitur ini berisikan data karyawan atau pengguna yang akan menggunakan sistem IMS
                        </p>
                        <br />

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 col">
                                <div class="d-flex justify-content-between align-item-center">
                                    <h5 class="m-0 font-weight-bold text-primary text-center">Data Karyawan</h5>
                                    <div class="d-flex">
                                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-icon-split mr-2">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-add"></i>
                                            </span>
                                            <span class="text">Tambah Data</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif

                                    @if ($message = Session::get('error'))
                                        <div class="alert alert-danger alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <div>{{ $error }}</div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <table class="table table-striped table-bordered mt-3 mb-3" id="dataTable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Alamat</th>
                                                <th>No. Telepon</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $User)
                                            <tr>
                                                <td>{{ $User->name }}</td>
                                                <td>{{ $User->gender }}</td>
                                                <td>{{ $User->address }}</td>
                                                <td>{{ $User->phone }}</td>
                                                <td>{{ $User->email }}</td>
                                                <td>
                                                    <form action="{{ route('users.destroy', $User->id) }}" method="POST">
                                                        <a href="{{ route('users.show', $User->id) }}" class="btn btn-info btn-circle btn-sm">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-circle btn-sm" onclick="return confirmDelete()">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <!--<a class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal">
                                                            <i class="fas fa-trash"></i>
                                                        </a> -->
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Select "Logout" below if you are ready to end your current session.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <form id="delete-form" method="POST" action="{{ route('users.destroy', $User->id) }}">
                            @csrf
                            @method('DELETE')
                            <a class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Hapus</a>
                        </form>
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

        <!-- Data Tables -->
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>

        <script>
            $(document).ready(function () {
                $("#dataTable").DataTable();
            });
        </script>

        <!-- Confirm Delete -->
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this item?');
            }
        </script>
    </body>
</html>
