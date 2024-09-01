<html>

<head>
        <title>Transit Information</title>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
   <style>
                .table {
                        margin: 20px auto;
                        width: 80%;
                }

                .table th,
                .table td {
                        padding: 10px;
                }

                .table-bordered {
                        border: 1px solid #dee2e6;
                }

                .table-striped tbody tr:nth-of-type(odd) {
                        background-color: #f9f9f9;
                }

                .table-hover tbody tr:hover {
                        background-color: #f5f5f5;
                }
        </style>
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
</nav>
<h1 style="text-align:center;padding:2%;">Station Information</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db = "transit2";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }
        ?>

        <table class="table table-hover table-bordered table-striped" align="center">
                <tr>
                        <th style="width: 10%;">Station ID</th>
                        <th>Station Name</th>
                </tr>

                <?php
                $query = mysqli_query($conn, "SELECT * FROM STATIONS") or die(mysqli_error($conn));

                while ($row = mysqli_fetch_array($query)) {
                        echo "<tr>
                                                                <td>{$row['StationID']}</td>
                                                                <td>{$row['StationName']}</td>
                                                  </tr>";
                }
                ?>
        </table>
        <h1 style="text-align:center;padding:2%;">Route Information</h1>
        <!--Bus Information-->
        <table class="table table-hover table-bordered table-striped" align="center">
                <tr>
                        <th>Route No.</th>
                        <th>Bus Stops</th>
                </tr>

                <?php
                $query = mysqli_query($conn, "SELECT r.routeid AS 'Route Number', GROUP_CONCAT(' ',s.stationname) AS 'Route Stops' from route r join bus_routes b on r.routeid = b.routeid join stations s on s.stationid = b.stationid GROUP BY r.routeid;") or die(mysqli_error($conn));

                while ($row = mysqli_fetch_array($query)) {
                        echo "<tr>
                                                                <td>{$row['Route Number']}</td>
                                                                <td>{$row['Route Stops']}</td>
                                                  </tr>";
                }
                ?>
        </table>
        <h1 style="text-align:center;padding:2%;">Driver's Schedule</h1>
        <!--Driver Information-->
        <table class="table table-hover table-bordered table-striped" align="center">
                <tr>
                        <th>Driver Name</th>
                        <th>Bus No.</th>
                        <th>Start Time</th>
                </tr>

                <?php
                $query = mysqli_query($conn, "
                    SELECT D.DriverId AS DriverID, D.DriverName AS DRIVER, B.BusNumber AS BUS_NUMBER, BS.StartTime AS StartTime
                    FROM 
                    DRIVER D JOIN BUS_SCHEDULE BS ON D.DriverID = BS.DriverID 
                    JOIN BUS B ON B.BusId = BS.BusId 
                    GROUP BY D.DriverId, D.DriverName, B.BusNumber,BS.StartTime ORDER BY B.BusNumber, BS.StartTime;


                ") or die(mysqli_error($conn));

                while ($row = mysqli_fetch_array($query)) {
                        $driver_id = $row['DriverID'];
                        $bus_number = $row['BUS_NUMBER'];
                        echo "<tr>
                            <td><a href='driver.php?driver_id={$driver_id} '>{$row['DRIVER']}</a></td>
                            <td><a href='bus.php?bus_no={$bus_number} '>{$row['BUS_NUMBER']}</td>
                            <td>{$row['StartTime']}</td>        
                          </tr>";
                }
                ?>
        </table>
        <h1 style="text-align:center;padding:2%;">Bus & Route Information</h1>
        <!--Route Information-->
        <table class="table table-hover table-bordered table-striped" align="center">
                <tr>
                        <th>Route Number</th>
                        <th>Bus No.</th>
                        <th>Bus Route</th>
                </tr>

                <?php
                $query = mysqli_query($conn, "
                SELECT B1.RouteID AS RouteNumber, B2.BusNumber AS BusNumber, GROUP_CONCAT(' ', S.StationName) AS 'Bus Route'
                FROM 
                BUS_ROUTES B1 JOIN BUS B2 ON B1.RouteID = B2.RouteID 
                JOIN STATIONS S ON B1.StationID = S.StationID 
                GROUP BY B1.RouteID, B2.BusNumber 
                ORDER BY B1.RouteID;
                ") or die(mysqli_error($conn));

                while ($row = mysqli_fetch_array($query)) {
                        echo "
                        <tr>
                            <td>{$row['RouteNumber']}</td>
                            <td>{$row['BusNumber']}</td>
                            <td>{$row['Bus Route']}</td>
                          </tr>";
                }
                ?>
        </table>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>