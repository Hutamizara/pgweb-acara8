
<?php
$conn = new mysqli("localhost", "root", "", "table_penduduk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("ID tidak valid.");
}

$stmt = $conn->prepare(
    "SELECT id, kecamatan, longtitude AS longitude, latitude, luas, jumlah_penduduk
    FROM table_penduduk WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    exit("Data tidak ditemukan.");
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Penduduk</title>
</head>
<body>
    <h2>Form Edit Data Penduduk</h2>

    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= e($data['id']) ?>">

        Kecamatan:<br>
        <input type="text" name="kecamatan"
            value="<?= e($data['kecamatan']) ?>" required><br><br>

        Longitude:<br>
        <input type="number" step="any" name="longitude"
            value="<?= e($data['longitude']) ?>" required><br><br>

        Latitude:<br>
        <input type="number" step="any" name="latitude"
            value="<?= e($data['latitude']) ?>" required><br><br>

        Luas:<br>
        <input type="number" step="any" min="0.01" name="luas"
            value="<?= e($data['luas']) ?>" required><br><br>

        Jumlah Penduduk:<br>
        <input type="number" min="1" step="1" name="jumlah_penduduk"
            value="<?= e($data['jumlah_penduduk']) ?>" required><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
