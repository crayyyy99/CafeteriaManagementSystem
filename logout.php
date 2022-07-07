<?php

/*This page processes the logout action*/

//Initialize session
session_start();

if(isset($_SESSION["username"])) 
{
    //Destroy the whole session
    $_SESSION = array();
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php\">"; //refresh in 2 second
}

?> 


