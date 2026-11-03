
<?php
$conn = new mysqli("localhost", "root", "", "table_penduduk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$kecamatan = trim($_POST["kecamatan"] ?? "");
$longitude = $_POST["longitude"] ?? "";
$latitude = $_POST["latitude"] ?? "";
$luas = $_POST["luas"] ?? "";
$jumlah = $_POST["jumlah_penduduk"] ?? "";

if (
    !$id || $id < 1 ||
    $kecamatan === "" ||
    !is_numeric($longitude) ||
    !is_numeric($latitude) ||
    !is_numeric($luas) || $luas <= 0 ||
    filter_var($jumlah, FILTER_VALIDATE_INT) === false ||
    $jumlah < 1
) {
    exit("Data tidak valid. Periksa kembali formulir.");
}

$stmt = $conn->prepare(
    "UPDATE table_penduduk
    SET kecamatan = ?, longtitude = ?, latitude = ?,
        luas = ?, jumlah_penduduk = ?
    WHERE id = ?"
);

$stmt->bind_param(
    "sdddii",
    $kecamatan,
    $longitude,
    $latitude,
    $luas,
    $jumlah,
    $id
);

if ($stmt->execute()) {
    header("Location: ../index.php");
    exit;
}

echo "Gagal memperbarui data.";

$stmt->close();
$conn->close();
?>
