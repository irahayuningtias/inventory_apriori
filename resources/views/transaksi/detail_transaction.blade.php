<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link
            rel="icon"
            href="{{ asset('assets/image/logo-hari-hari.png') }}"
        />
        <title>IMS - Detail Barang</title>

        <!-- Custom fonts for this template-->
        <link
            href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet"
        />
        <!-- Custom styles for this template-->
        <link
            href="{!! asset('assets/css/app.css') !!}"
            rel="stylesheet"
            type="text/css"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        />
        <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"
        />

        <!-- Custom styles for this page-->
        <link
            href="{!! asset('assets/css/dataTables.css') !!}"
            rel="stylesheet"
        />
    </head>

    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul
                class="navbar-nav sidebar sidebar-dark accordion"
                id="accordionSidebar"
            >
                <!-- Sidebar - Brand -->
                <a
                    class="sidebar-brand d-flex align-items-center justify-content-center"
                    href="index.html"
                >
                    <div class="sidebar-brand-icon">
                        <img
                            class="brand-icon"
                            src="{{ asset('assets/image/logo-hari-hari.png') }}"
                            alt="Hari Hari Store"
                            style="height: 50px; width: 50px"
                        />
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
                <li class="nav-item">
                    <a class="nav-link" href="users">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Karyawan</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseMasterData"
                        aria-expanded="true"
                        aria-controls="collapseMasterData"
                    >
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Master Data</span>
                    </a>
                    <div
                        id="collapseMasterData"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar"
                        style=""
                    >
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="category"
                                >Kategori</a
                            >
                            <a class="collapse-item" href="product">Barang</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapsePersediaan"
                        aria-expanded="true"
                        aria-controls="collapsePersediaan"
                    >
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Persediaan</span>
                    </a>
                    <div
                        id="collapsePersediaan"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar"
                        style=""
                    >
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Arus Persediaan</h6>
                            <a class="collapse-item" href="supply_in"
                                >Barang Masuk</a
                            >
                            <a class="collapse-item" href="supply_out"
                                >Barang Keluar</a
                            >
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
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseApriori"
                        aria-expanded="true"
                        aria-controls="collapseApriori"
                    >
                        <i class="fas fa-fw fa-sync"></i>
                        <span>Apriori</span>
                    </a>
                    <div
                        id="collapseApriori"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar"
                    >
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a
                                class="collapse-item"
                                href="apriori/apriori_process"
                                >Proses Apriori</a
                            >
                            <a
                                class="collapse-item"
                                href="apriori/apriori_result"
                                >Hasil Apriori</a
                            >
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseLaporan"
                        aria-expanded="true"
                        aria-controls="collapseLaporan"
                    >
                        <i class="fas fa-fw fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                    <div
                        id="collapseLaporan"
                        class="collapse"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar"
                    >
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Gudang</h6>
                            <a class="collapse-item" href="#">Laporan Harian</a>
                            <a class="collapse-item" href="#"
                                >Laporan Bulanan</a
                            >
                            <h6 class="collapse-header">Apriori</h6>
                            <a class="collapse-item" href="#"
                                >Laporan Analisis Apriori</a
                            >
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index">
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
                    <nav
                        class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
                    >
                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="userDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <span
                                        class="mr-2 d-none d-lg-inline text-gray-600 small"
                                        >{{ Auth::user()->name }}</span
                                    >
                                </a>
                                <!-- Dropdown - User Information -->
                                <div
                                    class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown"
                                >
                                    <a class="dropdown-item" href="#">
                                        <i
                                            class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"
                                        ></i>
                                        Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        data-toggle="modal"
                                        data-target="#logoutModal"
                                    >
                                        <i
                                            class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                                        ></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <!-- End of Topbar -->

                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <h7 class="m-0 font-weight-normal"
                            >Transaksi /
                            <a
                                href="{{ route('transaction.show', ['id' => $transaction->id]) }}"
                                >Detail Transaksi</a
                            ></h7
                        ><br /><br />

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 col">
                                <h5 class="m-0 font-weight-bold text-primary">
                                    Detail Barang
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <b>Kode Transaksi: </b
                                        >{{ $transaction->transaction_code }}
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tanggal: </b
                                        >{{ $transaction->transaction_date }}
                                    </li>
                                    <li class="list-group-item">
                                        <b>Nama Barang: </b> <br>
                                            @foreach($transaction->details as $details)
                                                    - {{ $details->product->product_name }} ({{ $details->quantity }}x) @Rp{{ number_format($details->price, 2, ',', '.') }}<br>
                                            @endforeach
                                    </li>
                                    <li class="list-group-item">
                                        <b>Subtotal: </b><br>
                                        @foreach($transaction->details as $details)
                                                    - Rp{{ number_format($details->subtotal, 2, ',', '.') }}<br>
                                                @endforeach
                                    </li>
                                    <li class="list-group-item">
                                        <b>Total Harga: </b
                                        >Rp{{ number_format($transaction->total_amount, 2, ',', '.') }}
                                    </li>
                                </ul>
                            </div>
                            <a
                                class="btn btn-primary mt-12"
                                href="{{ route('transaction') }}"
                                >Kembali</a
                            >
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span
                                >Copyright &copy; Inventory Management System -
                                Hari Hari Store 2024</span
                            >
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
        <div
            class="modal fade"
            id="logoutModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Ready to Leave?
                        </h5>
                        <button
                            class="close"
                            type="button"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Select "Logout" below if you are ready to end your
                        current session.
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-secondary"
                            type="button"
                            data-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="{{
                asset('assets/vendor/jquery/jquery.min.js')
            }}"></script>
        <script src="{{
                asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')
            }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{
                asset('assets/vendor/jquery-easing/jquery.easing.min.js')
            }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

        <!-- Page level plugins -->
        <script src="{{
                asset('assets/vendor/chart.js/Chart.min.js')
            }}"></script>
        <script src="{{
                asset('assets/js/dataTables.bootstrap4.min.js')
            }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script>

        <!-- Data Tables -->
        <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>

        <!-- perlu penambahan cdn -->
        <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    end of perlu penambahan cdn -->
    </body>
</html>