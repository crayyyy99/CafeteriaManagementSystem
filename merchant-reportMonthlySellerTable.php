<?php

/*This page display the daily best seller report Table  */

$now = date("Y-m-d");

if (isset($_POST['date-btn'])) {
    $search=$_POST["searchDate"];  
} 


$username = $_SESSION['username'];
$session = $_SESSION['session6'];

if($session!="Overall"){
    echo "Showing Best Seller of: <br><br>Month: <b>".date('F Y', strtotime($search));
    echo "</b><br>";
    echo "Session: <b>".$session;
    echo "</b><br><br>";

    $sql = "SELECT count(quantity) as count, items.id, item_name, category
    from orders join order_details on orders.id = order_id
    join items on order_details.item_id = items.id
    join merchants on (orders.merchant_id = merchants.id)

    where merchants.email ='".$username."' 
    AND session = '$session'  
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by item_name
    order by count DESC LIMIT 5;";
}   
else{
    echo "Showing Best Seller of: <br><br>Month: <b>".date('F Y', strtotime($search));
    echo "</b><br>";
    echo "Session: <b>".$session;
    echo "</b><br><br>";

    $sql = "SELECT count(quantity) as count, items.id, item_name, category
    from orders join order_details on orders.id = order_id
    join items on order_details.item_id = items.id
    join merchants on (orders.merchant_id = merchants.id)

    where merchants.email ='".$username."' 
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by item_name
    order by count DESC LIMIT 5";
} 
        
$result = $conn ->query($sql);

$i = 1;
if($result->num_rows > 0) {

//Display Best Seller Table
?>
    <div style="overflow-x:auto"> 
    <table>
    <tr><th>No.</th><th>Item ID</th><th>Item Name</th><th>Category</th><th>Quantity Sold</th></tr>   
<?php

    while($row = $result -> fetch_assoc()){   
        echo "<tr>";
        echo "<td style='width:4%'>" .$i. "</td>"; 
        echo "<td style='width:6%'># " . $row['id'] . "</td>"; 
        echo "<td style='width:23%'>" . $row['item_name'] . "</td>"; 
        echo "<td style='width:23%'>" . $row['category'] . "</td>"; 
        echo "<td style='width:23%'>" . $row['count'] . "</td>"; 
   
        $i++;
    }
    echo "</table></div>";     
    
}
else
{
 //   echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error; 
    echo "No record<br><br>";
}


$conn->close();

?>                    
