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
$qury="SELECT COUNT(items_description) AS number_of_item,SUM(quantity_supplied) AS sum_quantity_supplied,SUM(quantity_available) AS sum_quantity_available,SUM(quantity_sold) AS sum_quantity_sold,SUM(unit_selling_price) AS sum_unit_selling_price,SUM(unit_cost_price) AS sum_unit_cost_price,SUM(unit_item_profit) AS sum_unit_item_profit,SUM(total_profit) AS sum_total_profit,SUM(total_cost_price) AS sum_total_cost_price,SUM(total_selling_price) AS sum_total_selling_price FROM " .$obj->table;

//$result = $link->query("SELECT * FROM ".$obj->table." LIMIT ".$obj->limit);
$result = $link->query($qury);

$output = array();

$output = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($output);
?>