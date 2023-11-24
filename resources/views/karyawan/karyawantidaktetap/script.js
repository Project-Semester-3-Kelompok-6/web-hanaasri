$(document).ready(function () {
  // Memanggil metode GET dari API
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
        columnDefs: [
          {
            orderable: false,
            targets: 3,
          }, // Nonaktifkan pengurutan pada kolom Aksi
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

// Membuka Form Tambah
function redirectToForm() {
  // Menggunakan jQuery untuk menampilkan modal tambah
  $("#tambahModal").modal("show");
}

// Add this function to script.js
function showDetailModal(userId) {
  // Make an AJAX request to get user details
  $.ajax({
    url: "http://localhost/web-hanaasri/resources/views/karyawan/api.php?action=get_user_detail&id=" + userId,
    method: "GET",
    dataType: "json",
    success: function (user) {
      // Populate the modal with user details
      $("#detailNama").val(user.Nama);
      $("#detailEmail").val(user.Email);
      $("#detailDivisi").val(user.NamaDevisi);

      // Show the modal
      $("#detailModal").modal("show");
    },
    error: function (error) {
      console.error("Error fetching user details:", error);
    },
  });
}

// Memanggil method DELETE dari API
function deleteUser(userId, userName) {
  var confirmMessage =
    "Apakah Anda yakin ingin menghapus data karyawan " + userName + "?";

  if (confirm(confirmMessage)) {
    $.ajax({
      url:
        "http://localhost/web-hanaasri/resources/API/api.php?action=delete_user&id=" + userId,
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