<?php

/*This page shows the edit menu form*/

session_start();
include ('inc/connect.php');
date_default_timezone_set("Asia/Kuala_Lumpur");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -View Order</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style copy.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
             //control active page color in navigation bar
            <?php echo("var active = 'menu-nav';"); ?>
            <?php echo("var active2 = 'menu-nav-res';"); ?>
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                $("#edit-container").fadeIn();

                //Enlarge menu image when hover on them
                function hoverItem(){
                    $(".menu-table img").mouseenter(function(){
                        $(this).css("width", "350px");
                    });

                    $(".menu-table img").mouseleave(function(){
                        $(this).css("width", "50px");
                    });

                    
                }
                hoverItem();

                $("#cancel-btn").click(function(){ 
                    window.location.href = "merchant-menu.php";     
                });
            });

        </script>

        <style>
            .add-table input[type=reset]{
                width: auto;
                background-color: rgba(250, 128, 114, 0.6);
                color:black;
                font-size: 16px;
                cursor: pointer;
                letter-spacing: 1px;
                border: 1px solid #000000;
                border-bottom-width: 2.5px;
                border-radius: 6px;
                line-height: 18px;
                padding:10px;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>

        <?php include ('merchant-header.php');?>

        <section class="menu-container">
            
            <h3>Menu</h3> 
           
            <!--Allow merchant to select session to edit menu-->
            Date: <?php echo date('d/m/Y');?> <br><br>
            <form method = "POST" action="">
                Select Session:
                <select style="font-size:16px;" name = "session" size="1" onChange="this.form.submit()">
                    <option value='' disabled selected></option>
                    <option 
                    <?php if((isset($_POST['session']))&&($_POST['session']=='Morning')) echo "selected='selected'";
                    else if((isset($_SESSION['session']))&&($_SESSION['session']=='Morning')) {
                        echo "selected='selected'"; 
                    }?>>Morning</option>

                    <option 
                    <?php if((isset($_POST['session']))&&($_POST['session']=='Afternoon')) echo "selected='selected'";
                    else if((isset($_SESSION['session']))&&($_SESSION['session']=='Afternoon')) {
                        echo "selected='selected'"; 
                    }?>>Afternoon</option>

                    <option 
                    <?php if((isset($_POST['session']))&&($_POST['session']=='Evening')) echo "selected='selected'";
                    else if((isset($_SESSION['session']))&&($_SESSION['session']=='Evening')) {
                        echo "selected='selected'"; 
                    }?>>Evening</option>

                </select>
            </form><br>

            <table class="menu-table">
            <?php 
                if(isset($_POST["session"])){
                    $_SESSION["session"]=$_POST["session"];
                    include ("merchant-menuViewTable.php");
                }
                else if(isset($_SESSION["session"])){
                    include ("merchant-menuViewTable.php");
                }

            if(isset($_SESSION["session"])){
            ?>    
            <section style="clear:both"> 
                <br><br><hr style='border-top:1px dashed black;'><br>
            </section>

            <?php
    #Read selected item data from database

    $item_id=$_REQUEST['id'];

    $sql = "SELECT * FROM items JOIN item_details ON (items.id = item_id) 
    where item_id = '$item_id' ";      

    $result = $conn ->query($sql);

    if($result->num_rows > 0) {
        //output data of each row

        while($row = $result -> fetch_assoc()){

    ?>
        <h2>Edit Item</h2>
        <form action = "merchant-menuEditProcess.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="item_id" value="<?php echo $item_id;?>">
            <table class="add-table">
                <tr>
                    <th>Item Name<span style="color:red;font-weight:bolder;">*</span></th>
                    <td><input type="text" name="name" required value="<?php echo $row['item_name'];?>"
                    pattern='\S(.*\S)?' title='The field should not be null.' placeholder="required" ></td>
                </tr>
                <tr>
                    <th>Item Image</th>
                    <td><input type="file" name="image" style="border:none;"></td>
                </tr>                                     
                <tr>
                    <th>Item Description</th>
                    <td><input type="text" name="description" value="<?php echo $row['description'];?>"></td>
                </tr>              
                <tr>
                    <th>Item Category<span style="color:red;font-weight:bolder;">*</span></th>
                    <td>
                        <input type="text" name="category" id="category" required value="<?php echo $row['category'];?>"
                        pattern='\S(.*\S)?' title='The field should not be null.' placeholder="required">                  
                    </td>
                </tr>            
                <tr>
                    <th>Price (RM)<span style="color:red;font-weight:bolder;">*</span></th> 
                    <td><input type="number" name="price" min="0" step=".01" required placeholder="required" value="<?php echo number_format($row['price'],2); ?>"></td>
                </tr>   
                <tr>
                    <th>Stock<span style="color:red;font-weight:bolder;">*</span></th>
                    <td><input type="number" name="stock" min="0" required placeholder="required" value="<?php echo $row['stock_no'];?>"></td>
                </tr>     

                <tr><th colspan='2'> 
                    <input type='submit' name='submit' value='Save'>
                     <input type='reset' name = 'reset' value='Reset'>
                     <input id="cancel-btn" type='button' name = 'cancel' value='Cancel'>
                </th></tr>
                                
            </table>                 
            <br>              
        </form>      

    <?php    
        }
    }
    else 
    {
        echo "0 results";
    }

?>                                
        </section>
        
        <?php
        
        }
        include ('footer.php');?>

    </body>
</html>