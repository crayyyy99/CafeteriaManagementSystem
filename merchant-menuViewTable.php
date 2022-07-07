<?php
/*This page reads and displays table of menu without edit option*/

$merchant_id = $_SESSION['merchant_id'];
$session = $_SESSION['session'];
include ('inc/connect.php');


$sql = "SELECT * FROM items JOIN item_details ON (items.id = item_id) 
where session = '$session' and merchant_id = '$merchant_id' order by item_name ASC";

$result = $conn ->query($sql);

if($result->num_rows > 0) {

    echo "<tr style='line-height:30px;background:lightgrey;'><th colspan='2'>Item</th><th>Description</th><th>Category</th>
    <th>Price (RM)</th><th>Stock</th><th>Status</th></tr>";

    //output data of each row
    while($row = $result -> fetch_assoc()){
        
        echo "<tr>";
        echo "<td style='width:20%;'>" . $row['item_name'] . "</td>"; 
        if($row['image']==null) { ?>
            <td>&nbsp;</td>
        <?php } else { ?>
        <td style='width:5%;'><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" /> </td>

        <?php
        }
        echo "<td style='width:25%;'>" . $row['description'] . "</td>";  
        echo "<td style='width:18%;'>" . $row['category'] . "</td>";  
        echo "<td style='width:7%;'>" . number_format($row['price'],2) . "</td>";  
        echo "<td style='width:5%;'>" . $row['stock_no'] . "</td>"; 
        
        $_SESSION["item_id"]=$row['item_id'];

        if($row['stock_no']=="0")
            echo "<td style='width:7%;'><span style='color:blue;'>" . $row['status'] . "</span></td>"; 
        else
            echo "<td style='width:7%;'>" . $row['status'] . "</td>"; 

        ?>
        
        <?php
        echo "</tr>";
    }
    echo "</table><div>";
}      



?>