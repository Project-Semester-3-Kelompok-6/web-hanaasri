$(document).ready(function () {
    // Memanggil metode GET dari API
    $.ajax({
        url: "http://localhost/web-hanaasri/resources/views/tugaskaryawan/api_tugas_karyawan.php?action=get_job_now",
        method: "GET",
        dataType: "json",
        success: function (data) {
            // Memasukkan data ke dalam tabel
            for (var i = 0; i < data.length; i++) {
                var row =
                    "<tr>" +
                    "<td>" + (i + 1) + "</td>" +
                    "<td>" + data[i].Nama + "</td>" +
                    "<td>" + data[i].NamaDevisi + "</td>" +
                    "<td>" + data[i].Tanggal + "</td>" +
                    "<td>" + data[i].Judul + "</td>" +
                    "<td>" + data[i].Status + "</td>" +
                    "<td>" +
                    '<button class="btn btn-success me-1" onclick="showDetailModal(' + data[i].UserID + ')">Detail</button>' +
                    '<button class="btn btn-danger" onclick="deleteTask(' + data[i].JobID + ')">Delete</button>' +
                    "</td>" +
                    "</tr>";
                $("#table-body").append(row);
            }

            // Inisialisasi DataTable setelah memasukkan data
            var table = $("#example").DataTable({
                order: [],
                pageLength: 7,
                lengthChange: false,
                lengthMenu: [7, 10, 25, 50],  // Menentukan opsi jumlah entri yang ditampilkan
                columnDefs: [
                    {
                        orderable: false,
                        target: 0,
                    },
                    {
                        orderable: false,
                        target: 1,
                    },
                    {
                        orderable: false,
                        target: 2,
                    },
                    {
                        orderable: false,
                        target: 3,
                    },
                    {
                        orderable: false,
                        target: 4,
                    },
                    {
                        orderable: false,
                        target: 5,
                    },
                    {
                        orderable: false,
                        target: 6,
                    },
                ],
            });

            // Menangani reset nomor urut saat data disorting
            table
                .on("order.dt search.dt", function () {
                    table
                        .column(0, {
                            search: "applied",
                            order: "applied",
                        })
                        .nodes()
                        .each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                })
                .draw();
        },
        error: function (error) {
            console.error("Error fetching data:", error);
        },
    });
});

function deleteTask(jobID) {
    $.ajax({
        url: "http://localhost/web-hanaasri/resources/views/tugaskaryawan/api_tugas_karyawan.php?action=delete_task&id=" + jobID,
        method: "DELETE",
        dataType: "json",
        success: function (response) {
            console.log(response.message);
            location.reload(); // Refresh DataTable
        },
        error: function (error) {
            console.error("Error deleting task:", error);
        },
    });
}
