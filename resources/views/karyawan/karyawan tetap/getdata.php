<-- getdata -->

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
    <table id="example" class="display">
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
                            '<button class="btn btn-info btn-sm " onclick="editUser(' + data[i].UserID + ')">Edit</button>' +
                            '<button class="btn btn-danger btn-sm" onclick="deleteUser(' + data[i].UserID + ')">Delete</button>' +
                            '</td>' +
                            '</tr>';
                        $('#table-body').append(row);
                    }

                    // Inisialisasi DataTable setelah memasukkan data
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
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
</body>

</html>