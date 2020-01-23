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

$j->success='success';

$j->failure='failure';

$output = array($j->success=>'Saved');

$outpt = array($j->failure=>'failure');
 

$sql = "UPDATE bushara SET quantity_supplied='$ob->quantity_supplied', quantity_available='$ob->quantity_available', quantity_sold='$ob->quantity_sold', items_description='$ob->items_description', unit_selling_price='$ob->unit_selling_price',unit_cost_price='$ob->unit_cost_price',unit_item_profit='$ob->unit_item_profit',total_profit='$ob->total_profit', total_cost_price='$ob->total_cost_price',total_selling_price='$ob->total_selling_price' WHERE item_id ='$ob->item_id'";

if(mysqli_query($link, $sql)){

    echo json_encode($output); //'[{"success":"saved"}]';

} else{

    echo json_encode($outpt); //'[{"result":"not saved"}]'; //"ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>