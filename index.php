<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "table_penduduk";

// Create connection
$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM table_penduduk";
$result = $conn->query($sql);

echo "<a href='input/index.html'>Input Data</a>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>id</th>
                <th>kecamatan</th>
                <th>longitude</th>
                <th>latitude</th>
                <th>luas</th>
                <th>jumlah_penduduk</th>
                <th>Edit</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars((string)$row["id"], ENT_QUOTES, "UTF-8") . "</td>";
        echo "<td>" . htmlspecialchars((string)$row["kecamatan"], ENT_QUOTES, "UTF-8") . "</td>";
        echo "<td>" . htmlspecialchars((string)$row["longtitude"], ENT_QUOTES, "UTF-8") . "</td>";
        echo "<td>" . htmlspecialchars((string)$row["latitude"], ENT_QUOTES, "UTF-8") . "</td>";
        echo "<td>" . htmlspecialchars((string)$row["luas"], ENT_QUOTES, "UTF-8") . "</td>";
        echo "<td align='right'>" . htmlspecialchars((string)$row["jumlah_penduduk"], ENT_QUOTES, "UTF-8") . "</td>";
        echo "<td><a href='edit/index.php?id=" . rawurlencode((string)$row["id"]) . "'>Edit</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
