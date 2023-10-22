<?php
// include 'basic.php';

echo '<html>
<head>
<title>Itinerary</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="viewdetails.css">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="w3-light-grey">

<div class="w3-content" style="max-width:1400px">';

$dest = $_GET["dest"];
$nod = $_GET["nod"];

// echo $destination.$nod;
getit($dest, $nod);

function getit($d, $n)
{
    include 'basic.php';

    echo '<header class="w3-container w3-center w3-padding-32"> 
    <h1 class="heading">
      <span>P</span>
      <span>A</span>
      <span>C</span>
      <span>K</span>
      <span>A</span>
      <span>G</span>
      <span>E</span>
      <span class="space"></span>
      <span>D</span>
      <span>E</span>
      <span>T</span>
      <span>A</span>
      <span>I</span>
      <span>L</span>
      <span>S</span>
  </h1>
  </header>';

    $query = "SELECT ID FROM package WHERE destination = '$d' AND hmany = $n";
    $PID = mysqli_query($con, $query);

    if (!$PID) {
        echo "Error in selecting data: " . mysqli_error($con);
        return;
    }

    $p;
    $q;

    if (mysqli_num_rows($PID) > 0) {
        $p = mysqli_fetch_assoc($PID);
        $q = $p["ID"];
    }

    $squery = "SELECT * FROM itinerary WHERE pid = $q ORDER BY Dayno";
    $it = mysqli_query($con, $squery);

    while ($row = mysqli_fetch_assoc($it)) {
        echo '<!-- Grid -->
        <div class="w3-row">
        
        <!-- Blog entries -->
        <div class="w3-col l8 s12">
          <div class="w3-card-4 w3-margin w3-white">
            
            <div class="w3-container">
              <h3 class="place"><b>' . $row["Place"] . '</b></h3>
              <h5>Day <span class="w3-opacity">' . $row["Dayno"] . '</span></h5>
            </div>
        
            <div class="w3-container">
              <p>' . $row["Attraction"] . '</p>
               
            </div>
          </div>
          <hr>
        </div>';
    }

    echo "<br><br>Hotels associated with your stay:<br><br>";

    $squery = "SELECT * FROM hotel WHERE ID IN (SELECT hid FROM hotels_assoc_package WHERE pid=$q)";
    $hotel = mysqli_query($con, $squery);

    echo '<div class="w3-col l4">
    <div class="w3-card w3-margin w3-margin-top">
      <div class="w3-container w3-white">
        <table>
          <tr>
            <th>Hotel Name</th>
            <th>Rating</th>
            <th>City</th>
            <th>Room Type</th>
          </tr>';

    while ($row = mysqli_fetch_assoc($hotel)) {
        echo '<tr>
        <td>' . $row["Name"] . '</td>
        <td>' . $row["Rating"] . '</td>
        <td>' . $row["City"] . '</td>
        <td>
            <select id="Room">
              <option value="Premium">Premium</option>
              <option value="Deluxe">Deluxe</option>
              <option value="Regular">Regular</option>
            </select>
        </td>    
        </tr>';
    }

    echo "</table></div></div><hr></div></div><br>";

    echo '<div class="footer">
        <a href="http://localhost/Final%20sem3%20project/payment.php" class="btn center" style="font-size: large; display: inline-block;
        margin-top: 1rem; background:var(--orange); color:#fff; padding:.8rem 3rem; border:.2rem solid var(--orange);
        cursor: pointer; font-size: 1.7rem; border-radius: .5rem; text-decoration: none; width: 20%; align-items: center;
        padding: .5rem; background:rgba(0, 89, 255, 0.116); color:blue;">Pay Now</a>
      </div><br><br></body></html>';
}
?>
