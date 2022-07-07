<?php 

/*This page display the menu table data and the form for the user's input to make order*/

include ('inc/connect.php');
$merchant_id = $_SESSION["merchant_id"];
$session = $_SESSION["session"];
date_default_timezone_set("Asia/Kuala_Lumpur");

$sql="SELECT DISTINCT category FROM items";
$result = $conn ->query($sql);
if($result->num_rows > 0) {

    //output data of each row
    while($row = $result -> fetch_assoc()){

        $categories[] = $row['category'];
    }
}

echo "<tr style='line-height:30px;background:lightgrey;'><th>Select</th><th colspan='2'>Item</th><th>Description</th>
    <th>Price (RM)</th><th>Number of Item</th>";
    
$length = count($categories);

for ($i = 0; $i < $length; $i++) {
    
        $category = $categories[$i];
        
        $sql = "SELECT * FROM items JOIN item_details ON (items.id = item_id) 
        where session = '$session' and merchant_id = '$merchant_id' and category = '$category' and status ='Active' order by item_name ASC";

        $result = $conn ->query($sql);

        if($result->num_rows > 0) {
            echo "<tr style='line-height:30px;background:rgba(250, 128, 114, 0.5);'><th colspan='6'>".$categories[$i]."</th></tr>";
     
            while($row = $result -> fetch_assoc()){
                echo "<tr>";
                echo "<td style='width:10%;'><input type='checkbox' name='select[]' value='".$row['item_id']."'></td>"; 
                echo "<td style='width:20%;'>" . $row['item_name'] . "</td>"; 
                if($row['image']==null) { ?>
                    <td>&nbsp;</td>
                <?php } else { ?>
                <td style='width:5%;'><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" /> </td>
        
                <?php
                }
                echo "<td style='width:35%;'>" . $row['description'] . "</td>";  
          
                echo "<td style='width:15%;'>" . number_format($row['price'],2) . "</td>";  
                echo "<td style='width:15%;'><input style='font-size:16px;' type='number' min='0' max='".$row['stock_no']."' name='quantity[]' ></td>";
          
                ?>
                
                <?php
                echo "</tr>";
            }
            
        }
}?>
        
    </table>
    <section style="clear:both"> 
        <br><br>  <hr style='border-top:1px dashed black;width:100%;'><br>
    </section>

    <table style="border:none; width:auto;">
        <tr>
            <td style="border:none;">
                <label for="del-type">Delivery Type:</label>
                <select style="font-size:16px; width: auto;" name="del-type" id ="del-type"">
                    <option>Delivery to Hostel</option>
                    <option>Self Collect</option>
                </select>
                </td>
                <td style="border:none;">
                
                <section id="hostel_address">
                    Block - Floor - House - Room <br>
                                        
                    <select style="font-size:15px;" name="block">
                        <option>JEBAT</option>
                        <option>KASTURI</option>
                        <option>TUAH</option>
                        <option>LEKIR</option>
                        <option>LEKIU</option>                                                
                    </select>
                    -
                    <select style="font-size:15px;" name ="floor">
                        <option>1</option><option>2</option>
                        <option>3</option><option>4</option>
                        <option>5</option><option>6</option>
                        <option>7</option><option>8</option>
                        <option>9</option>
                    </select>
                    -                                
                    <select style="font-size:15px;" name ="house">
                        <option>1</option><option>2</option>
                        <option>3</option><option>4</option>
                        <option>5</option><option>6</option>
                        <option>7</option><option>8</option>
                        <option>9</option><option>10</option>
                        <option>11</option><option>12</option>
                    </select>                                
                    - 
                    <select style="font-size:15px;" name ="room">
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>D</option>
                        <option>E</option>
                    </select> 

                </section>
            </td>
            <td style="border:none;" >
            <label for="payment-type">Payment:</label>
            <select style="font-size:16px; width: auto;" name="payment-type" id ="payment-type"">
                    <option>Cash On Delivery</option>
                    <option>Online Banking</option>
                    <option>Bank Card</option>
            </select>
        </tr>
        <tr><td style="border:none;" colspan="3">&nbsp;</td></tr>
            
        <tr>
            <td style="border:none;" >
            <label for="collect-time">Delivery/Collecting Time:</label>
            <input id="collect-time" name="time" type="datetime-local" 
            max="<?php echo Date('Y-m-d', strtotime('+1 days'))."T".Date('H:i');?>" 
            min="<?php echo Date('Y-m-d')."T".Date('H:i');?>" 
            style="font-size:15px;" required >
            <br>(within one day)</td>

            <td colspan="2" style="border:none;" >
            <label for="request">Request:</label>
            <input style="font-size:15px;width:80%;" type = "text" name = "request" id ="request" 
            ></td>
            
        </tr>
        
    </table>

    <section style="text-align:center">
        <br>
        <input class="btn2" type='submit' name='submit' value='Create Order'>&nbsp;
        <input class="btn2" type='reset' name = 'reset' value='Reset'>
    </section>
   
</form>


<?php

$conn->close();

?>