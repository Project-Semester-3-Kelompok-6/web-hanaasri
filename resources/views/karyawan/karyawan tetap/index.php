<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Font -->
    <link rel="preconnect" class="nav-link" href="https://fonts.googleapis.com">
    <link rel="preconnect" class="nav-link" href="https://fonts.gstatic.com" crossorigin>
    <link class="nav-link" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<!-- CSS Bootstrap -->
<link class="nav-link" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- CSS DataTable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- CSS -->
<link rel="stylesheet" class="nav-link" href="index.css">


<!-- JS -->
<script src="index.js"></script>
<!-- JS Query -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<!-- JS DataTable -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<body>
    <div class="container-fluid">
        <div class="row row-cols-2">
            <div class="d-flex flex-column justify-content-between col-auto bg-light min-vh-100 custom-sidebar" id="sidebar">
                <div class="mt-4 w-100">
                    <div class="row row-cols-2" id="logotoggler">
                        <div class="d-flex justify-content-center col-sm-9">
                            <img src="img/Logo.png" alt="Logo Hana Asri" height="50px">
                        </div>
                        <div class="d-flex align-items-center justify-content-center col-sm-3 ms-auto">
                            <button class="navbar-toggler text-black border-1 rounded-5 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle sidebar" id="sidtog">
                                <span role="button"><i class="fa fa-bars" aria-hidden="true" style="color: #000000;"></i></span>
                            </button>
                        </div>
                    </div>
                    <hr class="text-black" />
                    <ul class="nav nav-pills flex-column mt-2 mt-sm-0" id="menu">
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#" aria-current="page" id="Dashboard">
                                <i class="fa-solid fa-house"></i>
                                <span class="ms-2">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#sidemenu" data-bs-toggle="collapse">
                                <i class="fa-solid fa-user"></i>
                                <span class="ms-2">Karyawan</span>
                            </a>
                            <ul class="nav collapse ms-3 flex-column show" id="sidemenu" data-bs-parent="#menu">
                                <li class="nav-item">
                                    <a class="nav-link text-black active" href="#">Karyawan Tetap</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black" href="#">Karyawan Tidak Tetap</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#" aria-current="page">
                                <i class="fa-regular fa-calendar-days"></i>
                                <span class="ms-2">Absen Karyawan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#" aria-current="page">
                                <i class="fa-solid fa-clipboard-list"></i>
                                <span class="ms-2">Tugas Karyawan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#" aria-current="page">
                                <i class="fa-solid fa-utensils"></i>
                                <span class="ms-2">Menu Makanan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#sidemenu-2" data-bs-toggle="collapse">
                                <i class="fa-solid fa-file"></i>
                                <span class="ms-2">Laporan</span>
                            </a>
                            <ul class="nav collapse ms-3 flex-column" id="sidemenu-2" data-bs-parent="#menu">
                                <li class="nav-item">
                                    <a class="nav-link text-black" href="#">Absensi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-black" href="#">Tugas</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="mb-5">
                    <button type="button" class="btn w-100 text-white" id="logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-xl-9 col-rows-1">
                <div class="container m-4">
                    <div class="position-relative">
                        <h1 class="text-black"> Karyawan Tetap</h1>
                        <button type="button" class="btn text-white" style="background-color: rgba(255, 145, 76, 1); position: absolute; top: 0; right: 0;">
                            <i class="fa-solid fa-plus"></i> Tambah Data
                        </button>
                    </div>

                    <div class="card p-2 mt-4">
                        <table id="example" class="display" width=100%>
                            <thead>
                                <tr>
                                    <th data-orderable="false">No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Devisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <!-- Data akan dimuat di sini melalui JavaScript -->
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function() {
                                // Memanggil metode GET dari API
                                $.ajax({
                                    url: 'http://localhost/web-hanaasri/resources/API/api.php?action=get_users',
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Memasukkan data ke dalam tabel
                                        for (var i = 0; i < data.length; i++) {
                                            var row = '<tr>' +
                                                '<td>' + (i + 1) + '</td>' +
                                                '<td>' + data[i].NamaKaryawan + '</td>' +
                                                '<td>' + data[i].NamaDevisi + '</td>' +
                                                '<td>' +
                                                '<button class="btn btn-success me-1" onclick="editUser(' + data[i].UserID + ')">Detail</button>' +
                                                '<button class="btn btn-primary me-1" onclick="editUser(' + data[i].UserID + ')">Edit</button>' +
                                                '<button class="btn btn-danger" onclick="deleteUser(' + data[i].UserID + ', \'' + data[i].NamaKaryawan + '\')">Delete</button>'
                                                '</td>' +
                                                '</tr>';
                                            $('#table-body').append(row);
                                        }


                                        // Inisialisasi DataTable setelah memasukkan data
                                        var table = $('#example').DataTable({
                                            "order": [],
                                            "columnDefs": [{
                                                    "orderable": false,
                                                    "targets": 3
                                                } // Nonaktifkan pengurutan pada kolom Aksi
                                            ]
                                        });

                                        // Menangani reset nomor urut saat data disorting
                                        table.on('order.dt search.dt', function() {
                                            table.column(0, {
                                                search: 'applied',
                                                order: 'applied'
                                            }).nodes().each(function(cell, i) {
                                                cell.innerHTML = i + 1;
                                            });
                                        }).draw();
                                    },
                                    error: function(error) {
                                        console.error('Error:', error);
                                    }
                                });
                            });

                            function deleteUser(userId, userName) {
    var confirmMessage = 'Apakah Anda yakin ingin menghapus data ' + userName + '?';

    if (confirm(confirmMessage)) {
        $.ajax({
            url: 'http://localhost/web-hanaasri/resources/API/api.php?action=delete_user&id=' + userId,
            method: 'DELETE',
            dataType: 'json',
            success: function(response) {
                console.log(response.message);
                // Refresh halaman atau muat ulang data jika diperlukan
                location.reload();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
}

                        </script>
                    </div>
                </div>

            </div>
        </div>
        <!-- Tambahkan script untuk Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>