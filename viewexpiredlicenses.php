<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
               <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding:1% 3%">
  <a class="navbar-brand" href="index.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="customerinfo.php">Customer Info</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="searchBus.php">Station Info</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="viewexpiredbuses.php">View Expired Buses</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="viewexpiredlicenses.php">View Expired Licenses</a>
      </li>
    </ul>
  </div>
</nav><div style="margin:30px; margin-bottom:50px;">
    <?php
     $servername = "localhost";
     $username = "root";
     $password = "root";
     $db = "transit2";
     $conn = new mysqli($servername, $username, $password, $db);
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     $driverQuery = "SELECT * FROM DRIVER WHERE LincenseExpireDate < '2038-10-10'";
$driverResult = $conn->query($driverQuery);

// Display results
echo "<h2>Expired Driver's Licenses</h2>
<table class='table table-hover table-bordered table-striped' align='center'>
                <tr>
                        <th>Driver Name</th>
                        <th>License Number</th>
                        <th>License Expire Date</th>
                </tr>";

                $query = mysqli_query($conn, "SELECT * FROM DRIVER WHERE LincenseExpireDate < CURDATE()") or die(mysqli_error($conn));

                while ($row = mysqli_fetch_array($query)) {
                        echo "<tr>
                                                                <td>{$row['DriverName']}</td>
                                                                <td>{$row['LicenseNumber']}</td>
                                                                <td>{$row['LincenseExpireDate']}</td>
                                                  </tr>";
                }
                ?>
        </table>
        </div>
        <div style="margin:30px;">
        <?php
        $driverQuery = "SELECT *, TIMESTAMPDIFF(YEAR, CURDATE(), LincenseExpireDate) AS ExpireIn FROM DRIVER WHERE TIMESTAMPDIFF(YEAR, CURDATE(), LincenseExpireDate) >= 0 ORDER BY ExpireIn ASC ;";
$driverResult = $conn->query($driverQuery);
echo "<h2>Driver's Licenses Expiring Soon</h2>
<table class='table table-hover table-bordered table-striped' align='center'>
        <tr>
            <th>Driver Name</th>
            <th>License Number</th>
            <th>License Expire Date</th>
            <th>Expires In</th>
        </tr>";

while ($row = mysqli_fetch_array($driverResult)) {
    echo "<tr>
            <td>{$row['DriverName']}</td>
            <td>{$row['LicenseNumber']}</td>
            <td>{$row['LincenseExpireDate']}</td>
            <td>{$row['ExpireIn']} Years</td>
          </tr>";
}

echo "</table>";
        ?>

</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>