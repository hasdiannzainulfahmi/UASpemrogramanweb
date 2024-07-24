<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kodebuku = $koneksi->real_escape_string($_POST['kodebuku']);
    $judulbuku = $koneksi->real_escape_string($_POST['judulbuku']);
    $isbn = $koneksi->real_escape_string($_POST['isbn']);
    $kodepenulis = $koneksi->real_escape_string($_POST['kodepenulis']);
    $kodepenerbit = $koneksi->real_escape_string($_POST['kodepenerbit']);
    $kodekategori = $koneksi->real_escape_string($_POST['kodekategori']);
    $tglterbit = $koneksi->real_escape_string($_POST['tglterbit']);
    $jlhhalaman = $koneksi->real_escape_string($_POST['jlhhalaman']);

    $sql = "INSERT INTO buku (kodebuku,judulbuku, isbn, kodepenulis, kodepenerbit, kodekategori, tglterbit, jlhhalaman) 
            VALUES ('$kodebuku','$judulbuku', '$isbn', '$kodepenulis', '$kodepenerbit', '$kodekategori', '$tglterbit', '$jlhhalaman')";

    if ($koneksi->query($sql) === TRUE) {
        header('Location: ../index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Buku</h2>
        <form action="create.php" method="POST">
        <div class="form-group">
                <label for="kodebuku">kodebuku</label>
                <input type="text" class="form-control" id="kodebuku" name="kodebuku" required>
            </div>
            <div class="form-group">
                <label for="judulbuku">Judul Buku</label>
                <input type="text" class="form-control" id="judulbuku" name="judulbuku" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="form-group">
                <label for="kodepenulis">Penulis</label>
                <select class="form-control" id="kodepenulis" name="kodepenulis" required>
                    <option value="">Pilih Penulis</option>
                    <?php
                    $result = $koneksi->query("SELECT kodepenulis, namapenulis FROM penulis");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['kodepenulis'] . "'>" . $row['namapenulis'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="kodepenerbit">Penerbit</label>
                <select class="form-control" id="kodepenerbit" name="kodepenerbit" required>
                    <option value="">Pilih Penerbit</option>
                    <?php
                    $result = $koneksi->query("SELECT kodepenerbit, namapenerbit FROM penerbit");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['kodepenerbit'] . "'>" . $row['namapenerbit'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="kodekategori">kategori</label>
                <select class="form-control" id="kodekategori" name="kodekategori" required>
                    <option value="">Pilih kategori</option>
                    <?php
                    $result = $koneksi->query("SELECT kodekategori, namakategori FROM kategori");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['kodekategori'] . "'>" . $row['namakategori'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tglterbit">Tanggal Terbit</label>
                <input type="date" class="form-control" id="tglterbit" name="tglterbit" required>
            </div>
            <div class="form-group">
                <label for="jlhhalaman">Jumlah Halaman</label>
                <input type="number" class="form-control" id="jlhhalaman" name="jlhhalaman" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
