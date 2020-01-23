<?php
header("Content-Type: application/json; charset=UTF-8");

$ob = json_decode($_POST["x"], false);

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "ebizebiz");
 
// Check connection
if($link === false){

    die("ERROR: Could not connect. " . mysqli_connect_error());

}

class Jsn
{
    public $success='';
    
    public $failure=''; 
}

$j = new Jsn();

$j->success='result';

$j->failure='result';

$output = array($j->success=> 'Saved');

$outpt = array($j->failure=> 'failure');
 
// Attempt insert query execution

 $sql = "INSERT INTO bushara (items_description, quantity_supplied, quantity_available, quantity_sold, unit_selling_price, unit_cost_price, unit_item_profit) VALUES('$ob->items_description', '$ob->quantity_supplied', '$ob->quantity_available', '$ob->quantity_sold', '$ob->unit_selling_price', '$ob->unit_cost_price', '$ob->unit_item_profit')";

if(mysqli_query($link, $sql)){

   echo json_encode($output);

} else{

    echo json_encode($outpt); //"ERROR: Could not able to execute $sql. " . mysqli_error($link);  
}
 
// Close connection
mysqli_close($link);
?>