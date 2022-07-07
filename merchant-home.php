<?php 

/*This page shows the merchant panel home page*/

if(!isset($_SESSION)){
    session_start();
}

$now = date("Y-m-d");

include ('inc/connect.php');

//Control session variable of other pages.
if(isset($_SESSION['session'])) {
    unset($_SESSION['session']);
 }
 if(isset($_SESSION['session2'])) {
     unset($_SESSION['session2']);
 }
 if(isset($_SESSION['session3'])) {
     unset($_SESSION['session3']);
 }
 if(isset($_SESSION['session4'])) {
    unset($_SESSION['session4']);
}
 if(isset($_SESSION['session5'])) {
     unset($_SESSION['session5']);
 }
 if(isset($_SESSION['session6'])) {
     unset($_SESSION['session6']);
 }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Home</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            //control active page color in navigation bar
            <?php echo("var active = 'home-nav';"); ?>
            <?php echo("var active2 = 'home-nav-res';"); ?>
        </script>
        
        <style>              
            .store-bg3{
                margin:left;
                display:flex;  
                flex-flow: row wrap;
                justify-content:space-evenly;
                margin-bottom: 30px;
                background-color: darkgray;
                width:100%;
                height:180px;
                border-radius: 5px;
                box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            }

            .store-bg3 p{
                width: 100%;
                margin-top: 70px;
                font-size: 30px;
                color:white;
                text-shadow:1px 1px 5px salmon, 1px 1px 5px salmon;
                text-align: center;
            }

        </style>

    </head>

    <body>
    
        <?php include ('merchant-header.php');?>

        <section class="home-container">
            <section>
                <section style="margin-bottom: 50px; padding-left:5px; padding-top:30px;padding-bottom:30px; background:LavenderBlush;">
                    <span style="font-size: 54px;"><b>SCOS</b></span>
                    <span style="font-size: 30px;color: #707070;font-weight: 100;margin: 20px 0 50px;"><b>Satria Cafeteria Ordering System</b></span>
                </section>

                <?php
                //read merchant data and display
               
                $sql = "SELECT * FROM merchants WHERE email = '$username'";

                $result = $conn ->query($sql);

                if($result->num_rows > 0) {
                    //output data of each row

                    while($row = $result -> fetch_assoc()){
                       $_SESSION['merchant_id']=$row['id'];
                       
                        ?>
                      <div class="store-bg3" style="
                      background:url(data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['business_bg']); ?>)
                        no-repeat;background-size: cover; background-position: 10% 55%;" >
                        <p><?php echo $row['business_name']; ?></p>
                
                <?php
                    }
                }
                ?>
                </div>
            </section>
            
            <!--Allow merchant to change business background image-->
            <form action = "merchant-homeBg.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name = "email" value = " <?php echo $username;?>">
                <input type="file" name="image" style="line-height:25px; font-size:15px;"><br>
                <input class="btn2" type="submit" name="submit" value="Change Business Background" >
            </form>           
                
             
            <br><br> <hr style='border-top:1px dashed black;'><br>

            <?php
            //Read pending request data
             $sql = "SELECT COUNT(DISTINCT orders.id) as count
             from orders join merchants on orders.merchant_id = merchants.id
             where orders.`status` = 'In Process' 
             AND merchants.email ='".$_SESSION['username']."'  
             AND orders.collect_time like '".$now."%'";

             $result = $conn ->query($sql);

             if($result->num_rows > 0) {
                while($row = $result -> fetch_assoc()){
                    $count = $row['count'];
                }
            }

            ?>

            <table width="100%" style="width:80%; margin: 0 auto; text-align:center;">
                <tr>
                    <td><h3>Pending request Today  : <span style="color:red;font-weight:bolder;font-size:50px;"><?php echo $count;?></span></h3></td>
                    <td><h3>Edit Menu:</h3></td>
                    <td><h3>View Sales Report:</h3></td>
                </tr>        
                <tr>        
                    <td><button class="btn4" onclick="location.href='merchant-order.php';">View Order</button></td>
                    <td><button class="btn4" onclick="location.href='merchant-menu.php';">Edit Menu</button></td>
                    <td><button class="btn4" onclick="location.href='merchant-reportDailySales.php';">View Report</button></td>    
                </tr>        
            </table>        
             
        </section>
        
        <br/><br/>
        
        <?php include ('footer.php');?>

    </body>
</html>