<?php 

/*This page shows the order-receipt when user clicked on the 'View Details' button*/
//The order receipt will be displayed based on the Delivery option -different SQL statement for each option

session_start();
include ('inc/connect.php');
date_default_timezone_set("Asia/Kuala_Lumpur");

if(isset($_REQUEST['id']))  
    $order_id=$_REQUEST['id'];
else
    $order_id = $_SESSION['order_id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Order Menu</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style copy.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
             //control active page color in navigation bar
            <?php echo("var active = 'order-nav';"); ?>
            <?php echo("var active2 = 'order-nav-res';"); ?>
        </script>

    </head>

    <body>

        <?php include ('user-header.php');?>
       
        <section class="receipt-container2">
            <center><br><h2>YOUR ORDER</h2><hr style='border-top:1px dashed black;width:60%;'></center>
            <section style="margin:0 auto;text-align:center;">
                <div class="receipt-border">
                <table style="margin:0 auto;border-collapse:collapse;width:90%;border-style:none;">
            <?php

            $sql = "SELECT delivery_opt as delivery from orders where orders.id= $order_id";
            
            $result = $conn ->query($sql);
            if($result->num_rows > 0) {
                while($row = $result -> fetch_assoc()){   
                    $checkDelType= $row['delivery'];
                }
            }

            if($checkDelType == "Delivery to Hostel"){
                $sql = "SELECT merchants.business_name as merchant, customers.`name` as customer,
                customers.contact as cusContact, merchants.contact as merContact,
                collect_time as collect, delivery_opt as delivery, payment_opt as payment,
                orders.`status` as orderStatus, hostel_id, request, items.`session`, block, floor, house, room
                from orders join order_details on (orders.id = order_id)  
                join customers on (customers.id = cus_id)
                join merchants on (merchant_id = merchants.id)
                join hostel_address on (hostel_id = hostel_address.id)
                join items on (order_details.item_id = items.id) 
                join item_details on (item_details.item_id = items.id) where orders.id=". $order_id." group by orders.id";
            }
            else if($checkDelType == "Self Collect"){
                $sql = "SELECT merchants.business_name as merchant, customers.`name` as customer,
                customers.contact as cusContact, merchants.contact as merContact,
                collect_time as collect, delivery_opt as delivery, payment_opt as payment,
                orders.`status` as orderStatus, hostel_id, request, items.`session`
                from orders join order_details on (orders.id = order_id)  
                join customers on (customers.id = cus_id)
                join merchants on (merchant_id = merchants.id)
                join items on (order_details.item_id = items.id) 
                join item_details on (item_details.item_id = items.id) where orders.id=". $order_id." group by orders.id";
            }       

            $result = $conn ->query($sql);
            if($result->num_rows > 0) {
                while($row = $result -> fetch_assoc()){   
                
                    echo "<tr><th>Date: </th><td>" . date('d-m-Y h:i A'). "</td></tr>";
                    echo "<tr><th>Store: </th><td>" . $row['merchant']. "</td></tr>";
                    echo "<tr><th>Store Contact: </th><td>" . $row['merContact']. "</td></tr>";
                    echo "<tr><th>Delivery Type: </th><td>" . $row['delivery']. "</td></tr>";
                    if($row['delivery']=="Delivery to Hostel"){
                        echo "<tr><th>Hostel Address: </th><td>" . $row['block']. " - " . $row['floor']. " - " 
                        . $row['house']. " - "  . $row['room']. "</td></tr>";
                    }
                    $collect = strtotime($row['collect']);
                    echo "<tr><th>Delivery/Collect Time: </th><td>" . date('d-m-Y h:i A', $collect). "</td></tr>";
                    if(empty($row['request']))
                        echo "<tr><th>Request: </th><td> - </td></tr>";
                    else
                        echo "<tr><th>Request: </th><td>" . $row['request']. "</td></tr>";
                }
            echo "</table><br>";
            }
            else
            {
                echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
 
            }
            $sql = "SELECT quantity, price, item_name,items.id,(quantity * price)as subprice
            from order_details join orders on (orders.id = order_id) 
            join items on (items.id = order_details.item_id) where orders.id = $order_id";

            $result = $conn ->query($sql);
            echo "<table style='margin:0 auto;border-collapse:collapse;width:90%;border-style:none;'>";
            echo "<tr style='border-bottom:1px black solid;border-top:1px black solid;
            line-height:30px;'><th>No.</th><th>Item</th><th>Quantity</th>
            <th>Price (RM)</th></tr>";
            $i = 1;
            while($row = $result -> fetch_assoc()){   
                echo "<tr>";
                echo "<td>" .$i. "</td>"; 
                echo "<td>" . $row['item_name'] . "</td>"; 
                echo "<td>" . $row['quantity'] . "</td>";  
                echo "<td>" . number_format($row['subprice'],2) . "</td>";  

                $i++;
            }
            echo "</tr>";

            $sql = "SELECT sum(quantity * price) as total
            from order_details join orders on (orders.id = order_id) 
            join items on (items.id = order_details.item_id) where orders.id = '$order_id'";
          
            $result = $conn ->query($sql);
            while($row = $result -> fetch_assoc()){   
                echo "<tr style='border-top:1px black solid;line-height:50px;'>
                <td colspan='4'><span style='font-weight:bold' >Total Payment (RM): </span>" . number_format($row['total'],2) . "</td></tr>";  
            }
 
            ?>


            </table>
        </div>
        </section>
        <div style="text-align:right;"><button class="btn2" onclick ="location.href='user-order.php';">Proceed</button></div>
    </section>
          
        <?php
        $conn->close();
              
        ?>                                           

        <?php include ('footer.php');?>

    </body>
</html>