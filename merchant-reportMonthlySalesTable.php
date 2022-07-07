<?php

/*This page display the monthly sales report Table  */

$now = date("Y-m-d");

if (isset($_POST['date-btn'])) {
    $search=$_POST["searchDate"];  
} 


$username = $_SESSION['username'];
$session = $_SESSION['session4'];


//Display No. of Sales and Total Sales (Overall):
 if($session!="Overall"){
    echo "Showing Sales of: <br><br>Month: <b>".date('F Y', strtotime($search));
    echo "</b><br>";
    echo "Session: <b>".$session;
    echo "</b><br><br>";
    $sql = "SELECT count(distinct orders.id) as count, sum(quantity * price) as total 
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by MONTH(orders.updated_at)";
}    
else{
    echo "Showing Sales of: <br><br>Month: <b>".date('F Y', strtotime($search));
    echo "</b><br>";
    echo "Session: <b>".$session;
    echo "</b><br><br>";
    $sql = "SELECT count(distinct orders.id) as count,  sum(quantity * price) as total 
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by MONTH(orders.updated_at)";
}
        
$result = $conn ->query($sql);

if($result->num_rows > 0) {
    while($row = $result -> fetch_assoc()){
        echo "Total No. of Sales: <b>".$row['count'];
        echo "</b><br>Total Sales:<b> RM ".number_format($row['total'],2)."</b>";
    }
}
echo "<br><br>";

//Delivery option = Self collect
if($session!="Overall"){
    $sql = "SELECT count(distinct orders.id) as count, sum(quantity * price) as total 
    , orders.updated_at as completeTime
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND delivery_opt='Self Collect'
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by DATE(orders.updated_at)
    order by orders.updated_at";
}   
else{
    $sql = "SELECT count(distinct orders.id) as count, sum(quantity * price) as total 
    , orders.updated_at as completeTime
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    where merchants.email ='".$username."'  
    AND delivery_opt='Self Collect'
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by DATE(orders.updated_at)
    order by orders.updated_at";
} 
        
$result = $conn ->query($sql);

$i = 1;
if($result->num_rows > 0) {

//Display Self collect Table
?>
    <hr><h3>Self Collect</h3>
    <div style="overflow-x:auto"> 
    <table>
    <tr><th>No.</th><th>Date</th><th>Total No. of Sales</th><th>Total Sales (RM)</th></tr>   
<?php

    while($row = $result -> fetch_assoc()){   
        echo "<tr>";
        echo "<td style='width:4%'>" .$i. "</td>"; 

        $complete = strtotime($row['completeTime']);
        echo "<td style='width:13%'>" . date('d-m-Y', $complete). "</td>"; 
        echo "<td style='width:15%;'>" .$row['count']. "</td>";  
        echo "<td style='width:15%;'>" . number_format($row['total'],2) . "</td>";  
        
        $i++;
    }
    echo "</table></div>";     
    
//Display No. of Sales and total sales (Self Collect):

    if($session!="Overall"){
        $sql = "SELECT count(distinct orders.id) as count,  sum(quantity * price) as total 
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND orders.`status`='Completed'
        AND orders.updated_at LIKE '".$search."%'
        AND delivery_opt='Self Collect'
        group by MONTH(orders.updated_at)";
    }    
    else{
        $sql = "SELECT count(distinct orders.id) as count,  sum(quantity * price) as total 
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND orders.`status`='Completed'
        AND orders.updated_at LIKE '".$search."%'
        AND delivery_opt='Self Collect'
        group by MONTH(orders.updated_at)";
    }
            
    $result = $conn ->query($sql);

    if($result->num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo "Total No. of Sales (Self Collect): ".$row['count'];
            echo "<br>Total Sales (Self Collect): RM ".number_format($row['total'],2);
        }
    }

echo "<br><br>";

}
else{
    echo "<hr><h3>Self Collect</h3>";
 //   echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error; 
    echo "No record<br><br>";
}


?>
<hr>

<?php
//Delivery option = Delivery to Hostel
if($session!="Overall"){
    $sql = "SELECT count(distinct orders.id) as count, sum(quantity * price) as total 
    , orders.updated_at as completeTime
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND delivery_opt='Delivery to Hostel'
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by DATE(orders.updated_at)
    order by orders.updated_at";
}    
else{
    $sql = "SELECT count(distinct orders.id) as count, sum(quantity * price) as total 
    , orders.updated_at as completeTime
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND delivery_opt='Delivery to Hostel'
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    group by DATE(orders.updated_at) 
    order by orders.updated_at";
}
        
$result = $conn ->query($sql);

$i = 1;
if($result->num_rows > 0) {

    //Display Delivery to Hostel Table
?>
    <h3>Delivery to Hostel</h3>
    <div style="overflow-x:auto"> 
    <table>
    <tr><th>No.</th><th>Date</th><th>Total No. of Sales</th><th>Total Sales (RM)</th></tr>   
<?php

    while($row = $result -> fetch_assoc()){   
        echo "<tr>";
        echo "<td style='width:4%'>" .$i. "</td>"; 

        $complete = strtotime($row['completeTime']);
        echo "<td style='width:13%'>" . date('d-m-Y', $complete). "</td>"; 
        echo "<td style='width:15%;'>" .$row['count']. "</td>";  
        echo "<td style='width:15%;'>" . number_format($row['total'],2) . "</td>";  
        
        $i++;
    }
    echo "</table></div>";     

//Display No. of Sales and total sales (Delivery to Hostel):

if($session!="Overall"){
    $sql = "SELECT count(distinct orders.id) as count,  sum(quantity * price) as total 
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    AND delivery_opt='Delivery to Hostel'
    group by MONTH(orders.updated_at)";
}    
else{
    $sql = "SELECT count(distinct orders.id) as count,  sum(quantity * price) as total 
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND orders.`status`='Completed'
    AND orders.updated_at LIKE '".$search."%'
    AND delivery_opt='Delivery to Hostel'
    group by MONTH(orders.updated_at)";
}
        
$result = $conn ->query($sql);

if($result->num_rows > 0) {
    while($row = $result -> fetch_assoc()){
        echo "Total No. of Sales (Delivery to Hostel): ".$row['count'];
        echo "<br>Total Sales (Delivery to Hostel): RM ".number_format($row['total'],2);
    }
}

echo "<br><br>";
                                            
}
else{
    echo "<h3>Delivery to Hostel</h3>";
    echo "No record<br><br>";
}

?>

<?php
$conn->close();

?>                    
