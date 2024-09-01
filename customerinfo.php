<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Search</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
    <style>
        #result-container {
            display: none;
            position: relative;
            width: 300px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            max-height: 150px;
            overflow-y: auto;
            margin:auto;
        }
        .result-item {
            padding: 10px;
            cursor: pointer;
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

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the search query
if (isset($_GET['customer'])) {
    $query = $_GET['customer'];
    $sql = "SELECT CustomerName FROM CUSTOMER WHERE CustomerName LIKE '%$query%'";
    $result = $conn->query($sql);

    $customers = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }

    // Return the results as JSON
    header('Content-Type: application/json');
    echo json_encode($customers);

    $conn->close();
    exit; // Terminate the script after handling the search query
}
?>
<div class="customer-add">
<h1 style="font-weight:bold;margin-bottom:5%;">Customer Search</h1>

<form action="subscriptioninfo.php/" method="get" style="background-color:lightgray;padding: 2%;border-radius:15px;width:60%;">
<div style="display:flex;justify-content:center; align-items:center;"><label for="customer-search" class="cust-label-add" style="font-size:1.3rem;font-weight:bold;">Search for a customer:</label>
    <input type="text" id="customer-search" name="customer" autocomplete="off" style="width:50%;height:30px;border-radius:5px;border:2px solid black;">
   </div>
     <div id="result-container"></div>
    <div style="display:flex;justify-content:center;padding:15px;">
    <button type="submit" style="padding:5px 15px;border-radius:25px;background-color:black;color:white;border:1px solid black;">Go to Customer Info</button></div>
    <!-- <a href='customer.php?bus_no={$bus_number} '>{$row['BUS_NUMBER']}</td>
                            <td>{$row['StartTime']} -->
</form>
</div>

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

<script>
    document.getElementById('customer-search').addEventListener('input', function() {
        let inputValue = this.value;
        if (inputValue.length > 0) {
            fetch('suggestcustomer.php?query=' + inputValue)
                .then(response => response.json())
                .then(data => {
                    let resultContainer = document.getElementById('result-container');
                    resultContainer.innerHTML = '';

                    if (data.length > 0) {
                        resultContainer.style.display = 'block';
                        data.forEach(customer => {
                            let item = document.createElement('div');
                            item.className = 'result-item';
                            item.textContent = customer.CustomerName;
                            item.addEventListener('click', function() {
                                document.getElementById('customer-search').value = customer.CustomerName; 
                                resultContainer.style.display = 'none';
                            });
                            resultContainer.appendChild(item);
                        });
                    } else {
                        resultContainer.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            document.getElementById('result-container').style.display = 'none';
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
