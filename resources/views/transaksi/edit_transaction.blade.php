<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset ('assets/image/logo-hari-hari.png') }}">
    <title>IMS - Edit Transaksi</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
                <div class="sidebar-brand-icon">
                    <img class="brand-icon" src="{{ asset('assets/image/logo-hari-hari.png') }}" alt="Hari Hari Store" style="height:50px; width:max-content 50px;">
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
                <a class="nav-link" href="#" data-toggle="modal" data-target="#passwordModal">
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
            <li class="nav-item active">
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile">
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

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h7 class="m-0 font-weight-normal">Transaksi / <a href="{{ route('transaction.edit', $transaction->id) }}">Edit Transaksi</a></h7><br><br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 col">
                            <h5 class="m-0 font-weight-bold text-primary">Form Edit Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('transaction.update', ['transaction' => $transaction->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="transaction_code" class="form-label font-weight-bold">Kode Transaksi</label>
                                            <input type="text" id="transaction_code" class="form-control" name="transaction_code" value="{{ $transaction->transaction_code }}">
                                            @error('transaction_code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="transaction_date" class="form-label font-weight-bold">Tanggal Transaksi</label>
                                            <input type="date" id="transaction_date" class="form-control" name="transaction_date" value="{{ $transaction->transaction_date }}">
                                            @error('transaction_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <h5 class="py-3 col font-weight-bold text-primary">Detail Transaksi</h5>
                                    <table id="product_table">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga Satuan</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->details as $index => $detail)
                                            <tr class="item">
                                                <td>
                                                    <input type="hidden" name="details[{{ $index }}][id]" value="{{$detail->id}}">

                                                    <select name="details[{{ $index }}][id_product]" class="form-control js-example-basic-single id_product" required>
                                                        <option value disabled >Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id_product }}" {{ $detail->product->id_product == $product->id_product  ? 'selected' : ''}}>{{ $product->product_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[{{ $index }}][quantity]" min="1" class="form-control quantity" value="{{ $detail->quantity }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="details[{{ $index }}][price]" min="0" class="form-control price" value="{{ $detail->product->price }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="details[{{ $index }}][subtotal]" class="form-control subtotal" value="{{ $detail->subtotal }}" readonly>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger remove_item" type="button" data-id="{{ $detail->id }}">Hapus</button>
                                                </td>
                                            </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                    @error('details.*.product_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('details.*.quantity')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('details.*.price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="mt-2 row">
                                    <div class="col-sm-12">
                                        <div class="d-grid gap-2 d-md-block">
                                            <button class="btn btn-warning" type="button" id="add_item">Tambah Barang</button>
                                            <input type="submit" class="btn btn-primary" value="Simpan"></input>
                                            <a class="btn btn-danger" href="javascript:window.history.go(-1);" role="button">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    // Fungsi untuk menambahkan produk
                                    $('#add_item').click(function() {
                                        var index = $('#product_table tbody tr').length;
                                        var row = `
                                            <tr class="item">
                                                <td>
                                                    <select name="details[${index}][id_product]" class="form-control js-example-basic-single id_product" required>
                                                        <option value="">Pilih Barang</option>
                                                        @foreach($products as $Product)
                                                            <option value="{{ $Product->id_product }}" data-price="{{ $Product->price }}">{{ $Product->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[${index}][quantity]" min="1" class="form-control quantity">
                                                </td>
                                                <td>
                                                    <input type="number" name="details[${index}][price]" min="0" class="form-control price" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="details[${index}][subtotal]" readonly class="form-control subtotal">
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger remove_item" type="button" data-id="{{ $detail->id }}">Hapus</button>
                                                </td>
                                            </tr>
                                        `;
                                        $('#product_table tbody').append(row);
                                        $('.js-example-basic-single').select2({
                                            ajax: {
                                                url: '{{ route("product.search") }}',
                                                dataType: 'json',
                                                delay: 250,
                                                processResults: function (data) {
                                                    return {
                                                        results: $.map(data, function (item) {
                                                            return {
                                                                id: item.id_product,
                                                                text: item.product_name
                                                            }
                                                        })
                                                    };
                                                },
                                                cache: true
                                            },
                                            placeholder: 'Select Product',
                                            minimumInputLength: 1
                                        });
                                    });

                                    // Fungsi untuk menghapus produk
                                    $(document).on('click', '.remove_item', function() {
                                        var detailId = $(this).data('id');
                                        if (detailId) {
                                            $('#product_table').append('<input type="hidden" name="deleted_details[]" value="' + detailId + '">');
                                        }
                                        $(this).closest('tr').remove();
                                    });

                                    // Fungsi untuk menghitung subtotal berdasarkan kuantitas dan harga satuan
                                    $(document).on('change', '.id_product', function() {
                                        var price = parseFloat($(this).find(':selected').data('price'));
                                        var row = $(this).closest('tr');
                                        row.find('.price').val(price);
                                        calculateSubtotal(row);
                                    });

                                    $(document).on('keyup', '.quantity', function() {
                                        var row = $(this).closest('tr');
                                        calculateSubtotal(row);
                                    });

                                    function calculateSubtotal(row) {
                                        var price = parseFloat(row.find('.price').val());
                                        var quantity = parseInt(row.find('.quantity').val());
                                        var subtotal = price * quantity;
                                        row.find('.subtotal').val(subtotal.toFixed(2));
                                    }
                                });
                            </script>

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
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Password -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Enter Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm" action="{{ route('users.password.validate') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('passwordForm').submit()">Submit</button>
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

</body>

</html>