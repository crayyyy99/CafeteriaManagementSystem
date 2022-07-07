<?php
session_start();


/*This page shows the menu page*/

date_default_timezone_set("Asia/Kuala_Lumpur");

//Control session variable of other pages.
#using session1
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

            <!--Allow merchant to select session to add menu-->
            Date: <?php echo date('d/m/Y');?> <br><br>
            <form method = "POST" action="">
                Select Session:
                <select style="font-size:16px;" name = "session" size="1" onChange="this.form.submit()">
                    <option value='' disabled selected></option>
                    <option 
                    <?php if((isset($_POST['session']))&&($_POST['session']=='Morning')) {
                        echo "selected='selected'";
                        $_SESSION['session'] = 'Morning';
                    }
                    else if((isset($_SESSION['session']))&&($_SESSION['session']=='Morning')) {
                        echo "selected='selected'"; 
                        $_SESSION['session'] = 'Morning';
                    }?>>Morning</option>

                    <option 
                    <?php if((isset($_POST['session']))&&($_POST['session']=='Afternoon')) {
                        echo "selected='selected'";
                        $_SESSION['session'] = 'Afternoon';
                    }
                    else if((isset($_SESSION['session']))&&($_SESSION['session']=='Afternoon')) {
                        echo "selected='selected'"; 
                        $_SESSION['session'] = 'Afternoon';
                    }?>>Afternoon</option>

                    <option 
                    <?php if((isset($_POST['session']))&&($_POST['session']=='Evening')) {
                        echo "selected='selected'";
                        $_SESSION['session'] = 'Evening';
                    }
                    else if((isset($_SESSION['session']))&&($_SESSION['session']=='Evening')) {
                        echo "selected='selected'"; 
                        $_SESSION['session'] = 'Evening';
                    }?>>Evening</option>

                </select>
            </form><br>


            <div style="overflow-x:auto"> 
            <table class="menu-table">
            <?php 
                if(isset($_POST["session"])){
                    $_SESSION["session"]=$_POST["session"];
                    include ("merchant-menuView.php");
                }
                else if(isset($_SESSION["session"])){
                    include ("merchant-menuView.php");
                }
                       
           
            if(isset($_SESSION["session"])){
            ?>    
            <section style="clear:both"> 
                <br><br><hr style='border-top:1px dashed black;'><br>
            </section>
         
            <!--Allow merchant to add new item-->
            <section id="add-container">
                <form action = "merchant-menuAdd.php" method="post" enctype="multipart/form-data">
                    <table class="add-table">
                        <tr>
                            <th>Item Name<span style="color:red;font-weight:bolder;">*</span></th>
                            <td><input type="text" name="name" required 
                            pattern='\S(.*\S)?' title='The field should not be null.' placeholder="required" ></td>
                        </tr>
                        <tr>
                            <th>Item Image</th>
                            <td><input type="file" name="image" style="border:none;"></td>
                        </tr>                                     
                        <tr>
                            <th>Item Description</th>
                            <td><input type="text" name="description"></td>
                        </tr>              
                        <tr>
                            <th>Item Category<span style="color:red;font-weight:bolder;">*</span></th>
                            <td>
                                <input type="text" list = "categories" name="category" id="category" required 
                                pattern='\S(.*\S)?' title='The field should not be null.' placeholder="required">
                                <datalist id="categories">
                                    <?php include ('merchant-menuCallDatalist.php');?>
                                </datalist>                   
                            </td>
                        </tr>            
                        <tr>
                            <th>Price (RM)<span style="color:red;font-weight:bolder;">*</span></th>
                            <td><input type="number" name="price" min="0" step=".01" required placeholder="required"></td>
                        </tr>   
                        <tr>
                            <th>Stock<span style="color:red;font-weight:bolder;">*</span></th>
                            <td><input type="number" name="stock" min="0" value="0" required placeholder="required"></td>
                        </tr>    
                        <tr><th colspan='2'> 
                            <input type='submit' name='submit' value='Add Item'>
                            <input type='reset' name = 'reset' value='Reset'>
                        </th></tr>
                                
                    </table>                 
                    <br>              
                </form>              
            </section>
                       

        </section>
        
        <?php
        
        }
        include ('footer.php');?>

    </body>
</html>