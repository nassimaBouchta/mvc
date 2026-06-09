<?php
include "../model/user.php";

session_start();
if (isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    echo "Welcome ".$user->getName();
    echo "<a href='../controller/userController.php?action=logout'>Logout</a>";
    
} else {
    // header('Location: login.html');
}