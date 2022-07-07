<?php

/*This page display the order table*/

if (isset($_POST['date-btn'])) {
    $search=$_POST["searchDate"];  
} 
else if (isset($_POST['month-btn'])) {
    $search=$_POST["searchMonth"];
} 
else {
    unset($search);
}

$username = $_SESSION['username'];

if(isset($search)){
    echo "Showing Order of Date: ".$search;
    echo "<br><br>";
    $sql = "SELECT sum(quantity * price) as total ,merchants.business_name, orders.id as order_id, orders.`status`, collect_time
    , orders.created_at
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) where customers.email ='".$username."'  
    AND orders.created_at LIKE '".$search."%'
    group by order_id order by `status` DESC, collect_time ";

}    
else{
    $sql = "SELECT sum(quantity * price) as total ,merchants.business_name, orders.id as order_id, orders.`status`, collect_time
    , orders.created_at
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) where customers.email ='".$username."'
    group by order_id order by `status` DESC, collect_time "; 
}
        
$result = $conn ->query($sql);

$i = 1;
if($result->num_rows > 0) {

?>
    <tr><th>No.</th><th>Store</th><th>Detail</th><th>Total Price (RM)</th><th>Status</th><th>Collect Time</th><th colspan="2">Created At</th></tr>   
<?php

    while($row = $result -> fetch_assoc()){   
        $_SESSION['order_id']=$row['order_id'];
        echo "<tr>";
        echo "<td style='width:5%'>" .$i. "</td>"; 
        echo "<td style='width:25%'>" . $row['business_name'] . "</td>"; 

?>     

        <td style='width:12%' name="edit-button" class="pink edit-button" align="center">
        <a href = "user-orderReceipt.php?id=<?php echo $row["order_id"];?>">View Details</a></td>
            
<?php
        echo "<td style='width:10%;'>" . number_format($row['total'],2) . "</td>";  
        if($row['status']=="In Process")
            echo "<td style='width:10%'><span style='color:blue'>" . $row['status'] . "</span></td>";  
        else
            echo "<td style='width:12%'>" . $row['status'] . "</td>";  

        $collect = strtotime($row['collect_time']);
        echo "<td style='width:13%'>" . date('d-m-Y h:i A', $collect). "</td>";

        $date = strtotime($row['created_at']);
        echo "<td style='width:15%'>" .date('d-m-Y h:i A', $date).  "</td>";

        if($row['status']=="In Process"){
        ?>
            <td style="width:20%" class="pink" ><a  onclick="return confirm('Are you sure?');" 
            href = "user-orderCancel.php?id=<?php echo $row["order_id"];?>">Cancel Order</a></td>
        <?php        
        }
        else{
            echo "<td>&nbsp;</td>";
        }

        $i++;
    }
}
else{
    echo "No record<br><br>";
}

$conn->close();

?>                    
