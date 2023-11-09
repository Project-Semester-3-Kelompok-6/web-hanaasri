<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sidebar.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="container">
        
        <div class="content">
            <table id="example">
                <thead>
                    <tr>
                        <th data-orderable="false">No</th>
                        <th>Nama Karyawan</th>
                        <th>Devisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "../../databases/database.php";
                    $karyawan_tp = mysqli_query($conn, "SELECT users.Nama AS NamaKaryawan, devisi.NamaDevisi AS NamaDevisi
                                                    FROM users
                                                    INNER JOIN devisi ON users.DevisiID = devisi.DevisiID
                                                    WHERE users.Status = 'Karyawan tetap'");
                    $nomor = 1;
                    while ($row = mysqli_fetch_array($karyawan_tp)) {
                        echo "<tr>
                    <td>$nomor</td>
                    <td>" . $row['NamaKaryawan'] . "</td>
                    <td>" . $row['NamaDevisi'] . "</td>
                    <td>
                    <button class='btn btn-primary edit-button'>Edit</button>
                    <button class='btn btn-danger delete-button'>Hapus</button>
                    </td>
                    </tr>";
                        $nomor++; //Tambah nomor urut(otomatis)
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "order": []
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
        });
    </script>
</body>
</html>
