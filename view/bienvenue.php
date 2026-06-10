<?php
include "../model/user.php";

session_start();
if (isset($_SESSION['user'])){
    $user=$_SESSION['user'];
    echo "Welcome ".$user->getName();
    echo "<a href='../controller/userController.php?action=logout'>Logout</a>";




    echo " | <a href='../view/conversation.php'> Conversation</a>";
    echo " | <a href='../controller/userController.php?action=logout'>Logout</a>";
} else {
    header('Location: ../view/login.html');
    exit;
}

?>