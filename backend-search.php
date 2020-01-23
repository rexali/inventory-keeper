<?php
/* 
Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password)
 */

/*
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
*******/

// Escape user inputs for security
require_once("config.php");

$term = mysqli_real_escape_string($link, $_REQUEST['term']);
 
if(isset($term)){
    // Attempt select query execution
    $sql = "SELECT items_description, quantity_supplied, quantity_available, quantity_sold, unit_selling_price FROM bushara WHERE items_description LIKE '" . $term . "%'";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                echo "<p>" . $row['items_description'] .', &nbsp;&nbsp;'. $row['quantity_supplied'] .',&nbsp;&nbsp;'. $row['quantity_available']. ',&nbsp;&nbsp;'. $row['quantity_sold'] .',&nbsp;&nbsp; Naira '. $row['unit_selling_price'] . "</p>";
            }
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<p>No matches found</p>";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}
 
// close connection
mysqli_close($link);
?>