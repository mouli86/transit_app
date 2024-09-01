<?php

$servername = "localhost";
$username = "root";
$password = "root";
$db = "transit2";
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT  StationName FROM STATIONS WHERE StationName LIKE '%$query%'";
    $result = $conn->query($sql);
    $customers = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($customers);
    $conn->close();
    exit;
}

?>