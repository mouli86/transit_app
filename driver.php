<?php
$var_value = $_GET['driver_id'];

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Driver Info</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="style.css">
 <style>
        .profile-card-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 20px;
        }

        .profile-card {
            width: 18rem;
        }

        .schedule-table {
            width: 50%;
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
    <div class="profile-card-container">
       
        <div class="profile-card">
        <h2>Driver Info</h2>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "transit2";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $db);
            $driverId = $_GET['driver_id'];

            $query = mysqli_query($conn, "
                SELECT * FROM DRIVER WHERE DriverId = $driverId;
            ") or die(mysqli_error($conn));

            while ($row = mysqli_fetch_array($query)) {
                echo "<div class='card' style='width: 18rem; margin-bottom: 20px;'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$row['DriverName']}</h5>
                            <p class='card-text'><b>Address</b><br>{$row['Address']}</p>
                            <p class='card-text'><b>Age</b> {$row['Age']}</p>
                            <p class='card-text'><b>License Number</b><br> {$row['LicenseNumber']}</p>
                            <p class='card-text'><b>License Expiration Date</b><br> {$row['LincenseExpireDate']}</p>
                        </div>
                    </div>";
            }
            ?>
        </div>
        <div class="schedule-table">
            <h2>Schedule</h2>
            <?php 
             $servername = "localhost";
             $username = "root";
             $password = "root";
             $db = "transit2";
             $conn = new mysqli($servername, $username, $password, $db);
             $driverId = $_GET['driver_id'];

             $query = mysqli_query($conn, "
             SELECT B.BusNumber AS BUS_NUMBER, BS.StartTime AS ShiftStartTime
             FROM 
             DRIVER D JOIN BUS_SCHEDULE BS ON D.DriverID = BS.DriverID 
             JOIN BUS B ON B.BusId = BS.BusId 
             WHERE D.DriverId = $driverId
             GROUP BY D.DriverId, D.DriverName, B.BusNumber,BS.StartTime ORDER BY B.BusNumber, BS.StartTime;
                ") or die(mysqli_error($conn));
                echo "<table class='table table-hover table-bordered table-striped' align='center'>
                <tr>
                        <th>Bus #</th>
                        <th>Start Time</th>
                </tr>";
                while ($row = mysqli_fetch_array($query)) {
                    echo "<tr>
                    <td>{$row['BUS_NUMBER']}</td>
                    <td>{$row['ShiftStartTime']}</td>
                    </tr>";
                }
                echo "</table>";
            ?>
        </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
