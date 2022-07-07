<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    </head>

    <body>
        <section class = "bg-img"></section>
        <section class= "login-container"> 
            <section style="text-align: center; margin:10px;">
                <a href="index.php"><img src = "image/logo.png" alt="logo" style="width:40%;"></a>
            </section>
            
            <form action="reset-pwdProcess.php" method="post" id="resetPwdForm" >

                <section style="text-align: center;">
                    <h3>Password Reset</h3>
                    <input type="email" id="email" name="email" placeholder="Enter Login Email Address" required>

                </section>

                <input type="submit" value="Reset Password">
                      
            </form>   
  
           
        </section>          

    </body>

</html>


