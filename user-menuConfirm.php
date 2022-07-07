<?php 
/*This page processes the order form submitted by the user*/
//The process based on the number of item selected(the checkbox) -one item or more than one item
//And the delivery option - Self collect or Delivery to Hostel

//If no item selected in the form or no number of item entered -> return false

session_start();
$merchant_id = $_SESSION["merchant_id"];
include ('inc/connect.php');

$cus_id = $_SESSION["cus_id"];
date_default_timezone_set("Asia/Kuala_Lumpur");
$now = date("Y-m-d H:i:s");

$delivery = $_POST['del-type'];
$block = $_POST['block'];
$floor = $_POST['floor'];
$house = $_POST['house'];
$room = $_POST['room'];
$collect_time = $_POST['time'];
$payment = $_POST['payment-type'];
$status = "In Process";

if(!isset ($_POST['select']))
{
    echo '<script>alert("Invalid action. No record selected")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-menuStore.php\">";     
}
else
{
    $countS = count($_POST['select']);

    $qArray = [];
    foreach($_POST['quantity'] as $q)
    {         
        if(!empty($q))
        {
            if($q != 0)
                array_push($qArray, $q);
        }
    }           
   
    $countQ = count($qArray);
        
    if($countQ != $countS)
    {
        echo '<script>alert("Invalid action. Please enter number of item.")</script>';
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-menuStore.php\">";     
    }
    else
    {
        if(!$_POST['request']==null)
        {
            $request = $_POST['request'];
        }

        if($countS ==1)
        {
           $quantity = current($qArray);

            if($delivery == "Delivery to Hostel")
            {
                $sql = "INSERT INTO hostel_address (block, floor, house, room)
                VALUES ('$block', '$floor', '$house', '$room')" 
                or die ("Error inserting data into table");

                if($conn->query($sql) === TRUE) {
                    $hostel_id = $conn->insert_id;

                    //insert into orders table
                    if($_POST['request'] == null){
                        $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, payment_opt, collect_time
                        , status, cus_id, merchant_id, hostel_id) VALUES ('$now', '$now', '$delivery', '$payment', '$collect_time'
                        , '$status',  '$cus_id' , '$merchant_id',  '$hostel_id')" 
                        or die ("Error inserting data into table");
                    }
                    else{
                        $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, request, payment_opt, collect_time
                        , status, cus_id, merchant_id, hostel_id) VALUES ('$now', '$now', '$delivery', '$request', '$payment', '$collect_time'
                        , '$status',  '$cus_id' , '$merchant_id',  '$hostel_id')" 
                        or die ("Error inserting data into table");
                    }
                    
                    if($conn->query($sql) === TRUE) {
                        $order_id = $conn->insert_id;
                        $item_id = $_POST['select'];
                            
                        $sql = "INSERT INTO order_details (quantity, created_at, updated_at, order_id, item_id)
                        VALUES ('$quantity[0]', '$now', '$now', '$order_id', '$item_id[0]')" 
                        or die ("Error inserting data into table");

                        if($conn->query($sql) === TRUE) {
                            $sql = "SELECT * from item_details JOIN items on items.id = item_id where item_id = $item_id[0]";
                            $result = $conn ->query($sql);      
                            if($result->num_rows > 0) {        
                                while($row = $result -> fetch_assoc()){
                                    $old_stock_no = $row['stock_no'];
                                }   
                            }

                            $new_stock_no = $old_stock_no - $quantity[0];

                            
                            $sql = "UPDATE item_details SET updated_at ='" .$now . "', stock_no = $new_stock_no where item_id = $item_id[0]";
                            $result = $conn ->query($sql);
                        
                            if($conn->query($sql) === TRUE) {

                                $_SESSION['order_id']= $order_id;
         
                                if($new_stock_no == 0)
                                {
                                    $status = "Inactive";
                                    $sql = "UPDATE items SET updated_at ='" .$now . "', status = '" .$status. "' where id = $item_id[0]";
                                    $result = $conn ->query($sql);  
                                }

                                echo '<script>alert("Successfully created order.")</script>';
                                echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-orderReceipt.php\">";  

                                if($conn->query($sql) === TRUE) {
                                }
                                else{
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                                
                            }
                            else{
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                           
                        }
                        else{
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }                
                    else{
                            echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
            #if self collect
            else
            {
               //insert into orders table
               if($_POST['request'] == null){
                $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, payment_opt, collect_time
                , status, cus_id, merchant_id) VALUES ('$now', '$now', '$delivery', '$payment', '$collect_time'
                , '$status',  '$cus_id' , '$merchant_id')" 
                or die ("Error inserting data into table");
                }
                else{
                    $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, request, payment_opt, collect_time
                    , status, cus_id, merchant_id) VALUES ('$now', '$now', '$delivery', '$request', '$payment', '$collect_time'
                    , '$status',  '$cus_id' , '$merchant_id')" 
                    or die ("Error inserting data into table");
                }
            
                if($conn->query($sql) === TRUE) {
                    $order_id = $conn->insert_id;
                    $item_id = $_POST['select'];
                        
                    $sql = "INSERT INTO order_details (quantity, created_at, updated_at, order_id, item_id)
                    VALUES ('$quantity[0]', '$now', '$now', '$order_id', '$item_id[0]')" 
                    or die ("Error inserting data into table");

                    if($conn->query($sql) === TRUE) {
                        $sql = "SELECT * from item_details JOIN items on items.id = item_id where item_id = $item_id[0]";
                        $result = $conn ->query($sql);      
                        if($result->num_rows > 0) {        
                            while($row = $result -> fetch_assoc()){
                                $old_stock_no = $row['stock_no'];
                            }   
                        }

                        $new_stock_no = $old_stock_no - $quantity[0];
                        
                        $sql = "UPDATE item_details SET updated_at ='" .$now . "', stock_no = $new_stock_no where item_id = $item_id[0]";
                        $result = $conn ->query($sql);
                    
                        if($conn->query($sql) === TRUE) {
                            $_SESSION['order_id']= $order_id;
     
                            if($new_stock_no == 0)
                            {
                                $status = "Inactive";
                                $sql = "UPDATE items SET updated_at ='" .$now . "', status = '" .$status. "' where id = $item_id[0]";
                                    $result = $conn ->query($sql);
                            }
                                echo '<script>alert("Successfully created order.")</script>';
                                echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-orderReceipt.php\">";  
                            

                            if($conn->query($sql) === TRUE) {
                            }
                            else{
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                            
                        }
                        else{
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                       
                    }
                    else{
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                else{
                        echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }  
        } 
        #multiple item
        if($countS > 1)
        {
            if($delivery == "Delivery to Hostel")
            {
                $sql = "INSERT INTO hostel_address (block, floor, house, room)
                VALUES ('$block', '$floor', '$house', '$room')" 
                or die ("Error inserting data into table");

                if($conn->query($sql) === TRUE) {
                    $hostel_id = $conn->insert_id;

                    //insert into orders table
                    if($_POST['request'] == null){
                        $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, payment_opt, collect_time
                        , status, cus_id, merchant_id, hostel_id) VALUES ('$now', '$now', '$delivery', '$payment', '$collect_time'
                        , '$status',  '$cus_id' , '$merchant_id',  '$hostel_id')" 
                        or die ("Error inserting data into table");
                    }
                    else{
                        $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, request, payment_opt, collect_time
                        , status, cus_id, merchant_id, hostel_id) VALUES ('$now', '$now', '$delivery', '$request', '$payment', '$collect_time'
                        , '$status',  '$cus_id' , '$merchant_id',  '$hostel_id')" 
                        or die ("Error inserting data into table");
                    }
                    
                    if($conn->query($sql) === TRUE) {
                        $order_id = $conn->insert_id;
                        $item_id = $_POST['select'];
                            
                        foreach (array_combine($_POST['select'], $qArray) as $item_id => $quantity){
                            $sql = "INSERT INTO order_details (quantity, created_at, updated_at, order_id, item_id)
                            VALUES ('$quantity', '$now', '$now', '$order_id', '$item_id')" 
                            or die ("Error inserting data into table");

                            if($conn->query($sql) === TRUE) {
                                $sql = "SELECT * from item_details JOIN items on items.id = item_id where item_id = $item_id";
                                $result = $conn ->query($sql);      
                                if($result->num_rows > 0) {        
                                    while($row = $result -> fetch_assoc()){
                                        $old_stock_no = $row['stock_no'];
                                    }   
                                }
    
                                $new_stock_no = $old_stock_no - $quantity;
    
                                
                                $sql = "UPDATE item_details SET updated_at ='" .$now . "', stock_no = $new_stock_no where item_id = $item_id";
                                $result = $conn ->query($sql);
                            
                                if($conn->query($sql) === TRUE) {
    
                                    $_SESSION['order_id']= $order_id;
             
                                    if($new_stock_no == 0)
                                    {
                                        $status = "Inactive";
                                        $sql = "UPDATE items SET updated_at ='" .$now . "', status = '" .$status. "' where id = $item_id";
                                            $result = $conn ->query($sql);
    
                                    }
    
                                    if($conn->query($sql) === TRUE) {
                                    }
                                    else{
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }
                                    
                                }
                                else{
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                               
                            }

                        } 
                        if($conn->query($sql) === TRUE) {
                            $_SESSION['order_id']= $order_id;
                            echo '<script>alert("Successfully created order.")</script>';
                            echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-orderReceipt.php\">";  
                        } 
                    }                
                    else{
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
            //if self collect
            else
            {
               //insert into orders table
               if($_POST['request'] == null){
                $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, payment_opt, collect_time
                , status, cus_id, merchant_id) VALUES ('$now', '$now', '$delivery', '$payment', '$collect_time'
                , '$status',  '$cus_id' , '$merchant_id')" 
                or die ("Error inserting data into table");
                }
                else{
                    $sql = "INSERT INTO orders (created_at, updated_at, delivery_opt, request, payment_opt, collect_time
                    , status, cus_id, merchant_id) VALUES ('$now', '$now', '$delivery', '$request', '$payment', '$collect_time'
                    , '$status',  '$cus_id' , '$merchant_id')" 
                    or die ("Error inserting data into table");
                }
            
                if($conn->query($sql) === TRUE) {
                    $order_id = $conn->insert_id;
                    $item_id = $_POST['select'];
                        
                    foreach (array_combine($_POST['select'], $qArray) as $item_id => $quantity){
                        $sql = "INSERT INTO order_details (quantity, created_at, updated_at, order_id, item_id)
                        VALUES ('$quantity', '$now', '$now', '$order_id', '$item_id')" 
                        or die ("Error inserting data into table");

                        if($conn->query($sql) === TRUE) {
                            $sql = "SELECT * from item_details JOIN items on items.id = item_id where item_id = $item_id";
                            $result = $conn ->query($sql);      
                            if($result->num_rows > 0) {        
                                while($row = $result -> fetch_assoc()){
                                    $old_stock_no = $row['stock_no'];
                                }   
                            }

                            $new_stock_no = $old_stock_no - $quantity;

                            
                            $sql = "UPDATE item_details SET updated_at ='" .$now . "', stock_no = $new_stock_no where item_id = $item_id";
                            $result = $conn ->query($sql);
                        
                            if($conn->query($sql) === TRUE) {

                                $_SESSION['order_id']= $order_id;
         
                                if($new_stock_no == 0)
                                {
                                    $status = "Inactive";
                                    $sql = "UPDATE items SET updated_at ='" .$now . "', status = '" .$status. "' where id = $item_id";
                                        $result = $conn ->query($sql);

                                }

                                if($conn->query($sql) === TRUE) {
                                }
                                else{
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                                
                            }
                            else{
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                           
                        }
                    }
                    if($conn->query($sql) === TRUE) {
                        $_SESSION['order_id']= $order_id;
                        echo '<script>alert("Successfully created order.")</script>';
                        echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-orderReceipt.php\">";  
                    }
                }
                else{
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }  
        }  

    }

}



//Closes specified connection
$conn->close();

?>