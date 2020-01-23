<?php
header("Content-Type: application/json; charset=UTF-8");

$obj = json_decode($_POST["x"], false);

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "ebizebiz");
 
// Check connection
if($link === false){

    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//item_id,quantity_supplied, quantity_available, quantity_sold, items_description, unit_selling_price,unit_cost_price,unit_item_profit,total_profit, total_cost_price,total_selling_price
$qury="SELECT * FROM " .$obj->table. " ORDER BY items_description  LIMIT " .$obj->limit;

//$result = $link->query("SELECT * FROM ".$obj->table." LIMIT ".$obj->limit);
$result = $link->query($qury);

$output = array();

$output = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($output);
?>