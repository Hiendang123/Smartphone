<?php
    session_start();
    session_destroy();
    if(isset($_COOKIE['email']) and isset($_COOKIE['pass'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    setcookie('email', $email, time()-1);
    setcookie('pass', $pass, time()-1);
}
    echo"You successfully logout . <br> click here to <a href='login.php'>login again</a>";
?>