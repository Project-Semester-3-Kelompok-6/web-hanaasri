$(document).ready(function () {
    
    isiDropdownDevisi();

    $("#togglePassword").click(function () {
        var passwordField = $("#detailPassword");
        var icon = $(this).find("i");

        // Toggle password visibility
        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    $("#togglePassword").click(function () {
        var passwordField = $("#inputPassword");
        var icon = $(this).find("i");
    
        // Toggle password visibility
        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    // Tambahkan fungsi untuk membersihkan formulir tambah setelah ditutup
$('#tambahModal').on('hidden.bs.modal', function () {
    $("#tambahForm")[0].reset();
    // Reset juga tampilan password jika sebelumnya diubah menjadi teks
    $("#inputPassword").attr("type", "password");
    $("#togglePassword").find("i").removeClass("fa-eye-slash").addClass("fa-eye");
});

    // Daftar Karyawan Tetap
    $.ajax({
        url: "http://localhost/web-hanaasri/resources/views/karyawan/api.php?action=get_users&status='Karyawan Tidak Tetap'",
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
                    "<td>" +
                    '<button class="btn btn-success me-1" onclick="showDetailModal(' + data[i].UserID + ')">Detail</button>' +
                    '<button class="btn btn-primary me-1" onclick="editUser(' + data[i].UserID + ')">Edit</button>' +
                    '<button class="btn btn-danger" onclick="deleteUser(' + data[i].UserID + ", '" + data[i].Nama + "')\">Delete</button>" +
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
                        target:3,
                    },
                ],
            });

            // Reset nomor urut saat data disorting
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

// Memanggil method DELETE dari API
function deleteUser(userId, userName) {
    var confirmMessage =
        "Apakah Anda yakin ingin menghapus data karyawan " + userName + "?";

    if (confirm(confirmMessage)) {
        $.ajax({
            url:
                "http://localhost/web-hanaasri/resources/views/karyawan/api.php?action=delete_user&id=" + userId,
            method: "DELETE",
            dataType: "json",
            success: function (response) {
                console.log(response.message);
                // Refresh halaman atau muat ulang data pada tablenya
                location.reload();
            },
            error: function (error) {
                console.error("Error deleting user:", error);
            },
        });
    }
}

// Show Detail Modal
function showDetailModal(userId) {
    // Get data user_details
    $.ajax({
        url: "http://localhost/web-hanaasri/resources/views/karyawan/api.php?action=get_user_detail&id=" + userId,
        method: "GET",
        dataType: "json",
        success: function (user) {
            // Populate the modal with user details
            $("#detailNama").val(user.Nama);
            $("#detailEmail").val(user.Email);
            $("#detailPassword").val(user.Password);
            $("#detailDivisi").val(user.NamaDevisi);

            // Show the modal
            $("#detailModal").modal("show");
        },
        error: function (error) {
            console.error("Error fetching user details:", error);
        },
    });
}

// Membuka Form Tambah
function redirectToForm() {
    // Menggunakan jQuery untuk menampilkan modal tambah
    $("#tambahModal").modal("show");
}

// Dropdown devisi
function isiDropdownDevisi() {
    $.ajax({
        url: "http://localhost/web-hanaasri/resources/views/karyawan/api.php?action=get_devisi",
        method: "GET",
        dataType: "json",
        success: function (data) {
            var dropdown = $("#inputDivisi");

            // Kosongkan dropdown terlebih dahulu
            dropdown.empty();

            // Tambahkan opsi-opsi devisi dari data yang diterima
            for (var i = 0; i < data.length; i++) {
                dropdown.append($("<option></option>").attr("value", data[i].DevisiID).text(data[i].NamaDevisi));
            }
        },
        error: function (error) {
            console.error("Error fetching devisi data:", error);
        },
    });
}


function simpanData() {
    // Mengambil nilai dari inputan modal
    var nama = $("#inputNama").val();
    var email = $("#inputEmail").val();
    var password = $("#inputPassword").val();
    var status = $("#inputStatus").val();
    var divisiID = $("#inputDivisi").val();
    
    // Pastikan data terisi dengan benar
    if (nama && email && password && status && divisiID) {
        // Lakukan permintaan AJAX untuk menyimpan data
        $.ajax({
            url: "http://localhost/web-hanaasri/resources/views/karyawan/api.php?action=add_user",
            method: "POST",
            data: {
                nama: nama,
                email: email,
                password: password,
                status: status,
                divisiID: divisiID,
            },
            dataType: "json",
            success: function (response) {
                console.log(response.message);
                // Setelah menyimpan data, tutup modal tambah
                $("#tambahModal").modal("hide");
                // Refresh halaman atau muat ulang data pada tabel
                location.reload();
            },
            error: function (error) {
                console.error("Error saving data:", error);
            },
        });
    } else {
        alert("Harap isi semua kolom data!");
    }
}