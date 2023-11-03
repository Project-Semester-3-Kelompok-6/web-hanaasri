<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="sidebar.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <section>
    <div class="sidebar">

    </div>
    <table id="example" class="display" style="width:100%">
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
            include "database.php";
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
            <td></td>
            </tr>";
                $nomor++; //Tambah nomor urut(otomatis)
            }
            ?>
        </tbody>
    </table>
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
    </section>
</body>

</html>