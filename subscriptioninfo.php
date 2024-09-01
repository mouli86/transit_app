<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  
    <title>Customer Subscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h4 {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            display: flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }

        .customer-info {
            width: 100%;
        display: flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            margin: 5% 0 10% 0;
        }

        .subscription-plan {
            width: 80%;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
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
    <div class="container">
        <div class="customer-info">
            <h4 style="text-align:center;">Customer Information</h4>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "transit2";
            $conn = new mysqli($servername, $username, $password, $db);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $customername = $_GET['customer'];
            $query = mysqli_query($conn,"
                SELECT distinct C.* FROM SUBSCRIPTION S
                JOIN PLAN P
                ON S.SubscriptionID = P.PlanID
                JOIN BUS_CARD B
                ON S.SubscriptionID = B.CardID
                JOIN TICKET T
                ON S.SubscriptionID = T.TicketID
                JOIN CUSTOMER C
                ON S.CustomerID = C. CustomerID
                WHERE CustomerName = '$customername';
            ") or die(mysqli_error($conn));
               while ($row = mysqli_fetch_array($query)) {
                    echo "<div class='card' style='width: 18rem; margin-bottom: 20px;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['CustomerName']}</h5>
                                <p class='card-text'><b>Date Of Birth</b><br> {$row['DOB']}</p>
                                <p class='card-text'><b>Gender</b><br>{$row['Gender']}</p>
                                <p class='card-text'><b>Address</b><br>{$row['Address']}</p>
                                <p class='card-text'><b>Phone No.</b> {$row['PhoneNumber']}</p>
                            </div>
                        </div>";
                }
                ?>
        </div>

        <div class="subscription-plan">
            <?php
              $servername = "localhost";
              $username = "root";
              $password = "root";
              $db = "transit2";
              $conn = new mysqli($servername, $username, $password, $db);
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }
              $customername = $_GET['customer'];
              $query = mysqli_query($conn,"
                SELECT C.*, PlanStartDate, PlanEndDate, PlanType, Amount, Balance, ExipreDate, TicketCost FROM SUBSCRIPTION S
                JOIN PLAN P
                ON S.SubscriptionID = P.PlanID
                JOIN BUS_CARD B
                ON S.SubscriptionID = B.CardID
                JOIN TICKET T
                ON S.SubscriptionID = T.TicketID
                JOIN CUSTOMER C
                ON S.CustomerID = C. CustomerID
                WHERE CustomerName = '$customername';
              ") or die(mysqli_error($conn));
                $row = mysqli_fetch_array($query);
                ?>
                <h4>Customer Subscription Plan</h4>
                <table>
                <tr>
                        <th>Plan Start Date</th>
                        <th>Plan End Date</th>
                        <th>Plan Type</th>
                        </tr>
                <?php
                $servername = "localhost";
                        $username = "root";
                $password = "root";
                $db = "transit2";
                $conn = new mysqli($servername, $username, $password, $db);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $customername = $_GET['customer'];
                $query = mysqli_query($conn,"
                    SELECT C.*, PlanStartDate, PlanEndDate, PlanType, Amount, Balance, ExipreDate, TicketCost FROM SUBSCRIPTION S
                    JOIN PLAN P
                    ON S.SubscriptionID = P.PlanID
                    JOIN BUS_CARD B
                    ON S.SubscriptionID = B.CardID
                    JOIN TICKET T
                    ON S.SubscriptionID = T.TicketID
                    JOIN CUSTOMER C
                    ON S.CustomerID = C. CustomerID
                    WHERE CustomerName = '$customername';
                ") or die(mysqli_error($conn));

                while ($row = mysqli_fetch_array($query)) {
                    echo "<tr>
                        <td>{$row['PlanStartDate']}</td>
                        <td>{$row['PlanEndDate']}</td>
                        <td>{$row['PlanType']}</td>
                    </tr>";
                }
                ?>
                </table>
                <h4>Card Balance History</h4>
                <table>
                <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        </tr>
                <?php
                 $servername = "localhost";
                 $username = "root";
                 $password = "root";
                 $db = "transit2";
                 $conn = new mysqli($servername, $username, $password, $db);
                 if ($conn->connect_error) {
                     die("Connection failed: " . $conn->connect_error);
                 }
                 $customername = $_GET['customer'];
                 $query = mysqli_query($conn,"
                   SELECT C.*,SubscriptionDate,PlanStartDate, PlanEndDate, PlanType, Amount, Balance, ExipreDate, TicketCost FROM SUBSCRIPTION S
                   JOIN PLAN P
                   ON S.SubscriptionID = P.PlanID
                   JOIN BUS_CARD B
                   ON S.SubscriptionID = B.CardID
                   JOIN TICKET T
                   ON S.SubscriptionID = T.TicketID
                   JOIN CUSTOMER C
                   ON S.CustomerID = C. CustomerID
                   WHERE CustomerName = '$customername';
                 ") or die(mysqli_error($conn));
                while ($row = mysqli_fetch_array($query)) {
                        echo "<tr>  
                                <td>{$row['SubscriptionDate']}</td>                                                  
                                <td>{$row['Amount']}</td>
                                <td>{$row['Balance']}</td>
                            </tr>";
                }
                ?>
                </table>
                <h4>Purchased Ticket Info</h4>
                <table>
                <tr>
                        <th>Exipre Date</th>
                        <th>Ticket Cost</th>
                        </tr>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "root";
                    $db = "transit2";
                    $conn = new mysqli($servername, $username, $password, $db);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $customername = $_GET['customer'];
                    $query = mysqli_query($conn,"
                      SELECT C.*,SubscriptionDate,PlanStartDate, PlanEndDate, PlanType, Amount, Balance, ExipreDate, TicketCost FROM SUBSCRIPTION S
                      JOIN PLAN P
                      ON S.SubscriptionID = P.PlanID
                      JOIN BUS_CARD B
                      ON S.SubscriptionID = B.CardID
                      JOIN TICKET T
                      ON S.SubscriptionID = T.TicketID
                      JOIN CUSTOMER C
                      ON S.CustomerID = C. CustomerID
                      WHERE CustomerName = '$customername';
                    ") or die(mysqli_error($conn));
                while ($row = mysqli_fetch_array($query)) {
                        echo "<tr>
                                                        <td>{$row['ExipreDate']}</td>
                                                        <td>{$row['TicketCost']}</td>
                                          </tr>";
                }
                ?>
                </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
