<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <!-- Tambahkan link ke file CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="verification.css">
</head>
<body>
    <div class="card rounded-5 p-4">
        <div class="text-center mt-2">
            <h2>Lupa Password</h2>
            <hr>
        </div>
        <form>
            <div class="mb-3">
                <label for="kodeVerifikasi" class="form-label">Masukkan Email</label>
                <input type="email" class="form-control" id="kodeVerifikasi">
            </div>
            <div class="mb-3 text-center p-0">
                <button type="submit" class="btn btn-primary w-50 mt-2 text-center">Kirim Kode Verifikasi</button>
            </div>
        </form>        
    </div>
</body>
</html>