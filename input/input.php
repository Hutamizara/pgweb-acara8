<?php
$kecamatan = trim($_POST["kecamatan"] ?? "");
$longitude = $_POST["longitude"] ?? "";
$latitude = $_POST["latitude"] ?? "";
$luas = $_POST["luas"] ?? "";
$jumlah_penduduk = $_POST["jumlah_penduduk"] ?? "";

if (
    $kecamatan === "" ||
    !is_numeric($longitude) ||
    !is_numeric($latitude) ||
    !is_numeric($luas) ||
    !is_numeric($jumlah_penduduk)
) {
    http_response_code(400);
    exit("Data formulir tidak valid.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "table_penduduk";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "INSERT INTO table_penduduk
    (kecamatan, longtitude, latitude, luas, jumlah_penduduk)
    VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sdddi",
    $kecamatan,
    $longitude,
    $latitude,
    $luas,
    $jumlah_penduduk
);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: ../index.php");
exit;
?>