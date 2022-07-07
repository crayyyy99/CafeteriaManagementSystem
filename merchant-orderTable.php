<?php
/*This page displays the order Table */

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
$session = $_SESSION['session2'];

//Delivery option = Self collect
if(isset($search)){
    echo "Showing Order of Collect Date: ".$search;
    echo "<br><br>";
    $sql = "SELECT sum(quantity * price) as total ,customers.name as customer, session, orders.id as order_id, orders.`status`
    , orders.created_at, collect_time, cancel_reason
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND delivery_opt='Self Collect'
    AND orders.collect_time LIKE '".$search."%'
    group by order_id order by  orders.`status` DESC , collect_time ASC";

}    
else{
    $sql = "SELECT sum(quantity * price) as total ,customers.name as customer, session, orders.id as order_id, orders.`status`
    , orders.created_at, collect_time, cancel_reason
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND delivery_opt='Self Collect'
    group by order_id order by  orders.`status` DESC,  collect_time ASC ";
}
        
$result = $conn ->query($sql);

$i = 1;
if($result->num_rows > 0) {

//Display Self Collect Table
?>
    <hr><h3>Self Collect</h3>
    <div style="overflow-x:auto"> 
    <table>
    <tr><th>No.</th><th>Order ID</th><th>Customer</th><th>Item Detail</th><th>Collect Time</th><th colspan = "2">Status</th><th colspan="2">Created At</th></tr>   
<?php

    while($row = $result -> fetch_assoc()){   
        $_SESSION['order_id']=$row['order_id'];
        echo "<tr>";
        echo "<td style='width:4%'>" .$i. "</td>"; 
        echo "<td style='width:6%'># " . $row['order_id'] . "</td>"; 
        echo "<td style='width:23%'>" . $row['customer'] . "</td>"; 

?>     

        <td style='width:8%' name="edit-button" class="pink edit-button" align="center">
        <a href = "merchant-orderReceipt.php?id=<?php echo $row["order_id"];?>">View Details</a></td>
            
<?php
       
       $collect = strtotime($row['collect_time']);
       echo "<td style='width:13%'>" . date('d-m-Y h:i A', $collect). "</td>";

        if($row['status']=="In Process")
            echo "<td style='width:7%'><span style='color:blue'>" . $row['status'] . "</span></td>";  
        else
            echo "<td style='width:7%'>" . $row['status'] . "</td>";  

        if($row['status']=="In Process"){
        ?>
            <td style="width:12%" class="pink" ><a  onclick="return confirm('Are you sure this order has completed?');"  
            href = "merchant-orderUpdate.php?id=<?php echo $row["order_id"];?>">Update Status</a></td>
        <?php
        }
        else if($row['status']=="Cancelled"){
            echo "<td style='width:15%'>" . $row['cancel_reason'] . "</td>";  
        }
        else{
            echo "<td>&nbsp;</td>";
        }

        $date = strtotime($row['created_at']);
        echo "<td style='width:13%'>" .date('d-m-Y h:i A', $date).  "</td>";

        if($row['status']=="In Process"){
        ?>
            <td style="width:8%" class="pink" ><a  onclick="return confirm('Are you sure?');" 
            href = "merchant-orderCancel.php?id=<?php echo $row["order_id"];?>">Cancel Order</a></td>
        <?php        
        }
        else{
            echo "<td>&nbsp;</td>";
        }

        $i++;
    }
    echo "</table></div>";     
    
//Display No. of orders:

    if(isset($search)){
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND orders.collect_time LIKE '".$search."%'
        AND delivery_opt='Self Collect'";
        
    
    }    
    else{
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND delivery_opt='Self Collect'";
    }
            
    $result = $conn ->query($sql);

    if($result->num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo "Total No. of Order: ".$row['count'];
        }
    }

//Display No. of Uncompleted Order:
    if(isset($search)){
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND orders.collect_time LIKE '".$search."%'
        AND delivery_opt='Self Collect'
        AND orders.status = 'In Process'";
        
    
    }    
    else{
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND delivery_opt='Self Collect'
        AND orders.status = 'In Process'";
    }
            
    $result = $conn ->query($sql);
    
    if($result->num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo "<br><br>Total No. of Incompleted Order: ".$row['count'];
        }
    }

//Display No. of Completed Order
    if(isset($search)){
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND orders.collect_time LIKE '".$search."%'
        AND delivery_opt='Self Collect'
        AND orders.status = 'Completed'";
        
    
    }    
    else{
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND delivery_opt='Self Collect'
        AND orders.status = 'Completed'";
    }
            
    $result = $conn ->query($sql);
    
    if($result->num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo "<br><br>Total No. of Completed Order: ".$row['count'];
        }
    }

//Display No. of Cancelled Order
        if(isset($search)){
            $sql = "SELECT count(distinct orders.id) as count
            from orders join merchants on (merchant_id = merchants.id)
            join customers on (customers.id = cus_id) 
            join order_details on (orders.id = order_id) 
            join items on (items.id = order_details.item_id) 
            
            where merchants.email ='".$username."'  
            AND session = '$session'
            AND orders.collect_time LIKE '".$search."%'
            AND delivery_opt='Self Collect'
            AND orders.status = 'Cancelled'";
            
        
        }    
        else{
            $sql = "SELECT count(distinct orders.id) as count
            from orders join merchants on (merchant_id = merchants.id)
            join customers on (customers.id = cus_id) 
            join order_details on (orders.id = order_id) 
            join items on (items.id = order_details.item_id) 
            
            where merchants.email ='".$username."'  
            AND session = '$session'
            AND delivery_opt='Self Collect'
            AND orders.status = 'Cancelled'";
        }
                
        $result = $conn ->query($sql);
        
        if($result->num_rows > 0) {
            while($row = $result -> fetch_assoc()){
                echo "<br><br>Total No. of Cancelled Order: ".$row['count'];
            }
        }

echo "<br><br>";

}
else{
    echo "<hr><h3>Self Collect</h3>";
    echo "No record<br><br>";
}

echo "<hr>";

//Delivery option = Delivery to Hostel
if(isset($search)){
    $sql = "SELECT sum(quantity * price) as total ,customers.name as customer, session, orders.id as order_id, orders.`status`
    , orders.created_at, collect_time, cancel_reason, block
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    join hostel_address on (hostel_address.id = orders.hostel_id)
    
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND delivery_opt='Delivery to Hostel'
    AND orders.collect_time LIKE '".$search."%'
    group by order_id order by  orders.`status` DESC,collect_time ASC , block ASC";

}    
else{
    $sql = "SELECT sum(quantity * price) as total ,customers.name as customer, session, orders.id as order_id, orders.`status`
    , orders.created_at, collect_time, cancel_reason, block
    from orders join merchants on (merchant_id = merchants.id)
    join customers on (customers.id = cus_id) 
    join order_details on (orders.id = order_id) 
    join items on (items.id = order_details.item_id) 
    join hostel_address on (hostel_address.id = orders.hostel_id)
    
    where merchants.email ='".$username."'  
    AND session = '$session'
    AND delivery_opt='Delivery to Hostel'
    group by order_id order by orders.`status` DESC, collect_time ASC , block ASC";
}
        
$result = $conn ->query($sql);

$i = 1;
if($result->num_rows > 0) {

//Display Delivery to Hostel Table
?>
    <h3>Delivery to Hostel</h3>
    <div style="overflow-x:auto"> 
    <table>
    <tr><th>No.</th><th>Order ID</th><th>Customer</th><th>Block</th><th>Item Detail</th><th>Collect Time</th><th colspan = "2">Status</th><th colspan="2">Created At</th></tr>   
<?php

    while($row = $result -> fetch_assoc()){   
        $_SESSION['order_id']=$row['order_id'];
        echo "<tr>";
        echo "<td style='width:4%'>" .$i. "</td>"; 
        echo "<td style='width:6%'># " . $row['order_id'] . "</td>"; 
        echo "<td style='width:18%'>" . $row['customer'] . "</td>"; 
        echo "<td style='width:5%'>" . $row['block'] . "</td>"; 

?>     

        <td style='width:8%' name="edit-button" class="pink edit-button" align="center">
        <a href = "merchant-orderReceipt.php?id=<?php echo $row["order_id"];?>">View Details</a></td>
            
<?php
       
       $collect = strtotime($row['collect_time']);
       echo "<td style='width:13%'>" . date('d-m-Y h:i A', $collect). "</td>";

        if($row['status']=="In Process")
            echo "<td style='width:7%'><span style='color:blue'>" . $row['status'] . "</span></td>";  
        else
            echo "<td style='width:7%'>" . $row['status'] . "</td>";  

        if($row['status']=="In Process"){
        ?>
            <td style="width:12%" class="pink" ><a  onclick="return confirm('Are you sure this order has completed?');"  
            href = "merchant-orderUpdate.php?id=<?php echo $row["order_id"];?>">Update Status</a></td>
        <?php
        }
        else if($row['status']=="Cancelled"){
            echo "<td style='width:15%'>" . $row['cancel_reason'] . "</td>";  
        }
        else{
            echo "<td>&nbsp;</td>";
        }

        $date = strtotime($row['created_at']);
        echo "<td style='width:13%'>" .date('d-m-Y h:i A', $date).  "</td>";

        if($row['status']=="In Process"){
        ?>
            <td style="width:8%" class="pink" ><a  onclick="return confirm('Are you sure?');" 
            href = "merchant-orderCancel.php?id=<?php echo $row["order_id"];?>">Cancel Order</a></td>
        <?php        
        }
        else{
            echo "<td>&nbsp;</td>";
        }

        $i++;
    }
    echo "</table></div>";  

    //Display No. of orders:

    if(isset($search)){
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND orders.collect_time LIKE '".$search."%'
        AND delivery_opt='Delivery to Hostel'";
        
    
    }    
    else{
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND delivery_opt='Delivery to Hostel'";
    }
            
    $result = $conn ->query($sql);

    if($result->num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo "Total No. of Order: ".$row['count'];
        }
    }

//Display No. of Uncompleted Order:
    if(isset($search)){
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND orders.collect_time LIKE '".$search."%'
        AND delivery_opt='Delivery to Hostel'
        AND orders.status = 'In Process'";
        
    
    }    
    else{
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND delivery_opt='Delivery to Hostel'
        AND orders.status = 'In Process'";
    }
            
    $result = $conn ->query($sql);
    
    if($result->num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo "<br><br>Total No. of Incompleted Order: ".$row['count'];
        }
    }

//Display No. of Completed Order
    if(isset($search)){
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND orders.collect_time LIKE '".$search."%'
        AND delivery_opt='Delivery to Hostel'
        AND orders.status = 'Completed'";
        
    
    }    
    else{
        $sql = "SELECT count(distinct orders.id) as count
        from orders join merchants on (merchant_id = merchants.id)
        join customers on (customers.id = cus_id) 
        join order_details on (orders.id = order_id) 
        join items on (items.id = order_details.item_id) 
        
        where merchants.email ='".$username."'  
        AND session = '$session'
        AND delivery_opt='Delivery to Hostel'
        AND orders.status = 'Completed'";
    }
            
    $result = $conn ->query($sql);
    
    if($result->num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo "<br><br>Total No. of Completed Order: ".$row['count'];
        }
    }

//Display No. of Cancelled Order
        if(isset($search)){
            $sql = "SELECT count(distinct orders.id) as count
            from orders join merchants on (merchant_id = merchants.id)
            join customers on (customers.id = cus_id) 
            join order_details on (orders.id = order_id) 
            join items on (items.id = order_details.item_id) 
            
            where merchants.email ='".$username."'  
            AND session = '$session'
            AND orders.collect_time LIKE '".$search."%'
            AND delivery_opt='Delivery to Hostel'
            AND orders.status = 'Cancelled'";
            
        
        }    
        else{
            $sql = "SELECT count(distinct orders.id) as count
            from orders join merchants on (merchant_id = merchants.id)
            join customers on (customers.id = cus_id) 
            join order_details on (orders.id = order_id) 
            join items on (items.id = order_details.item_id) 
            
            where merchants.email ='".$username."'  
            AND session = '$session'
            AND delivery_opt='Delivery to Hostel'
            AND orders.status = 'Cancelled'";
        }
                
        $result = $conn ->query($sql);
        
        if($result->num_rows > 0) {
            while($row = $result -> fetch_assoc()){
                echo "<br><br>Total No. of Cancelled Order: ".$row['count'];
            }
        } 
        echo "<br><br>";
        
    ?>



    <?php                                            
}
else{
    echo "<h3>Delivery to Hostel</h3>";
    echo "No record<br><br>";
}



$conn->close();

?>                    
