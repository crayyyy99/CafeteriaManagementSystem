<?php 

/*This page shows the order page with session option selection*/

if(!isset($_SESSION)){
    session_start();
}

include ('inc/connect.php');
date_default_timezone_set("Asia/Kuala_Lumpur");

//Control session variable of other pages.
#using session2
if(isset($_SESSION['session'])) {
    unset($_SESSION['session']);
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

if(isset($search)) {
    unset($search);
 }

?>


<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -View Order</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            //control active page color in navigation bar
            <?php echo("var active = 'order-nav';"); ?>
            <?php echo("var active2 = 'order-nav-res';"); ?>

            function resetTable(){
                <?php
                  unset($search);
                ?>
            }

        </script>
 
    </head>

    <body>
       
        <?php include ('merchant-header.php');?>
        
        <section class="merchant-order-container">
            <h2>Order</h2>

             <!--To allow merchant to select session to view order by session -->
            <form id="session-form" method = "POST" action="">
                Select Session:
                <select style="font-size:16px;" name = "session" size="1" onChange="this.form.submit()">
                    <option value='' disabled selected></option>
                    <option 
                    <?php if((isset($_POST['session']))&&($_POST['session']=='Morning')) {
                            echo "selected='selected'";
                            $_SESSION['session2'] = 'Morning';
                        }
                        else if((isset($_SESSION['session2']))&&($_SESSION['session2']=='Morning')) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Morning';
                        }
                        else if( (isset($_POST['date-btn'])) && ($_SESSION['session2']=='Morning') ) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Morning';
                        }
                        else if( (isset($_POST['month-btn'])) && ($_SESSION['session2']=='Morning') ) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Morning';
                        }
                        ?>>Morning
                    </option>

                        <option 
                        <?php if((isset($_POST['session']))&&($_POST['session']=='Afternoon')) {
                            echo "selected='selected'";
                            $_SESSION['session2'] = 'Afternoon';
                        }
                        else if((isset($_SESSION['session2']))&&($_SESSION['session2']=='Afternoon')) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Afternoon';
                        }
                        else if( (isset($_POST['date-btn'])) && ($_SESSION['session2']=='Afternoon') ) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Afternoon';
                        }
                        else if( (isset($_POST['month-btn'])) && ($_SESSION['session2']=='Afternoon') ) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Afternoon';
                        }
                        ?>>Afternoon</option>

                        <option 
                        <?php if((isset($_POST['session']))&&($_POST['session']=='Evening')) {
                            echo "selected='selected'";
                            $_SESSION['session2'] = 'Evening';
                        }
                        else if((isset($_SESSION['session2']))&&($_SESSION['session2']=='Evening')) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Evening';
                        }
                        else if( (isset($_POST['date-btn'])) && ($_SESSION['session2']=='Evening') ) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Evening';
                        }
                        else if( (isset($_POST['month-btn'])) && ($_SESSION['session2']=='Evening') ) {
                            echo "selected='selected'"; 
                            $_SESSION['session2'] = 'Evening';
                        }
                        ?>>Evening</option>

                    </select>                      
            </form><br>

        <?php 
            if(isset($_SESSION['session2'])){
        ?>
         <!--To allow merchant to select date to display orders of selected date or month-->
                <form method = "POST" action="">
                    Select Collect Date: <input type="date" name="searchDate" id="searchDate"  value="<?php if(isset($POST['searchDate'])){ echo $POST['searchDate'];}?>">                      
                    <button type="submit" name="date-btn" id="date-btn"><i class=" fa fa-search btn1" ></i></button>  
                    &nbsp;&nbsp;&nbsp; or &nbsp;&nbsp;&nbsp;

                    Month: <input type="month" name="searchMonth">
                    <button type="submit" name="month-btn" id="month-btn"><i class=" fa fa-search btn1" ></i></button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <button onclick="resetTable();" class="btn1">Reset Table</button><br><br><br>
                </form>    
                
                <section class="history-container">             
                    
        <?php 
                    if(isset($_POST["session"])){
                        $_SESSION["session2"]=$_POST["session"];
                        include ("merchant-orderTable.php");
                    }
                    else{
                        include ("merchant-orderTable.php");
                    }
  
            }
            echo "</section>"; 
        ?>

        </section>

        <?php include ('footer.php');?>

    </body>
</html>