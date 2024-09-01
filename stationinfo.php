<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  
    <title>Stations Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f2f2f2;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        h4 {
            margin-top: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding:1% 3%">
  <a class="navbar-brand" href="/DBProject/index.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/DBProject/customerinfo.php">Customer Info</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/DBProject/searchBus.php">Station Info</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/DBProject/viewexpiredbuses.php">View Expired Buses</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/DBProject/viewexpiredlicenses.php">View Expired Licenses</a>
      </li>
    </ul>
  </div>
</nav>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$db = "transit2";
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$stationname = $_GET['station'];
$query = mysqli_query($conn,"
SELECT B.RouteID AS RouteID, GROUP_CONCAT(' ',StationName) AS BusStops, BU.BusNumber AS BusNumber FROM BUS_ROUTES B
JOIN STATIONS S
ON B.StationID = S.StationID 
JOIN BUS BU
ON B.RouteID = Bu.RouteID
WHERE B.RouteID IN (SELECT RouteID FROM BUS_ROUTES WHERE StationID IN (SELECT StationID FROM STATIONS WHERE StationName = '$stationname'))
GROUP BY B.RouteID,  BU.BusNumber;
") or die(mysqli_error($conn));

echo "<h1 style='padding:5%'>$stationname</h1>";

while ($row = mysqli_fetch_array($query)) {
    echo "<h2 style='text-align:center;'>Route Number - {$row['RouteID']}</h2>
        <h2 style='text-align:center;'>Bus Number - {$row['BusNumber']}</h2>
        <h4 style='text-align:center;'>Stations On Route</h4> 
        <table class='table table-hover table-bordered table-striped' align='center'>
            <tr>
                <td style='text-align:center;'>{$row['BusStops']}</td>
            </tr>
        </table>";
}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>