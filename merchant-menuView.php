<?php
/*This page reads and displays table of menu with edit and delete option*/


$session = $_SESSION['session'];
include ('inc/connect.php');


$sql = "SELECT * FROM items JOIN item_details ON (items.id = item_id) 
where session = '$session' and merchant_id = '$merchant_id' ";

$result = $conn ->query($sql);

if($result->num_rows > 0) {

    echo "<tr style='line-height:30px;background:lightgrey;'><th colspan='2'>Item</th><th>Description</th><th>Category</th>
    <th>Price (RM)</th><th>Stock</th><th>Status</th>";
    echo "<th style='text-align:center;' colspan = '2'>Update</th></tr>";

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

        if($row['stock_no']=="0")
            echo "<td style='width:7%;'><span style='color:blue;'>" . $row['status'] . "</span></td>"; 
        else
            echo "<td style='width:7%;'>" . $row['status'] . "</td>"; 

        ?>

        <td style='width:auto;text-align:center;' name="edit-button" class="pink edit-button" align="center">
        <a href = "merchant-menuEdit.php?id=<?php echo $row["item_id"];?>">Edit</a></td>
        <td style='width:auto;text-align:center;' class="pink" align="center">
        <a onclick="return confirm('Are you sure?');" href = "merchant-menuDelete.php?id=<?php echo $row["item_id"];?>">Delete</a></td>
        
        <?php
        echo "</tr>";
    }
    echo "</table><div>";
}      
else
{
    echo "<tr style='line-height:30px;background:lightgrey;'><th colspan='2'>Item</th><th>Description</th><th>Category</th>
    <th>Price (RM)</th><th>Stock</th>";
    echo "<th style='text-align:center;' colspan = '2'>Update</th></tr>";
    echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;
    </td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
    echo "</table><div>";

}

$conn->close();

?>