<?php
include 'basic.php';
// include 'itinerary.php';
echo '<head><link rel="stylesheet" type="text/css" href="booking.css"></head>';

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$destination = $fwhere = $hmany = $departure = $arrival = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $destination = test_input($_POST["destination"]);
  $fwhere = test_input($_POST["fwhere"]);
  $hmany = test_input($_POST["hmany"]);
  $departure = test_input($_POST["departure"]);
  $arrival = test_input($_POST["arrival"]);
}

$diff = strtotime($arrival) - strtotime($departure);
$nod = ceil($diff / 86400) + 1;
$basecharge = 10000;
$persons = ceil((float)$nod / 2);
$regamt = $basecharge + ($persons * $nod) * 3000;
$deluxamt = $basecharge + ($persons * $nod) * 5000;
$premamt = $basecharge + ($persons * $nod) * 7000;

// INSERT query
$query = "INSERT INTO `package` (destination, fwhere, hmany, departure, arrival) VALUES ('$destination', '$fwhere', '$hmany', '$departure', '$arrival')";
$insertResult = mysqli_query($con, $query);

if ($insertResult) {
  // Display the message for successful INSERT

  // SELECT query
  $selectQuery = "SELECT * FROM package";
  $selectResult = mysqli_query($con, $selectQuery);

  if ($selectResult) {
    if (mysqli_num_rows($selectResult) > 0) {
      // Display packages if there are rows
      echo "<div class=\"filter\"></div><table><tr><th>Destination</th><th>No. of Days</th><th>Starting from</th><th>View Details</th></tr>";

      while ($row = mysqli_fetch_assoc($selectResult)) {
        $d = $row['destination'];
        $n = $row['hmany'];
        echo "<tr><td>" . $row['destination'] . "</td><td>" . $row['hmany'] . "</td><td>$regamt</td><td><a href='itinerary.php/?dest=$d&nod=$n'>View Details</a></td></tr>";
      }

      echo "</table>";
    } else {
      // No packages found
      echo "Sorry, we don't have packages for $destination that are $hmany days long right now.";
    }
  } else {
    echo "Error in selecting data: " . mysqli_error($con);
  }
} else {
  // Display error message for unsuccessful INSERT
  echo "Error in inserting data: " . mysqli_error($con);
}
?>
