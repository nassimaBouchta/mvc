<?php
include '../doa/messageDOA.php';
include '../Model/user.php';
session_start();
$action = $_GET['action'];

$doa = new messageDOA();

switch($action){
    case "send":
        $msg = $_POST['message'];
        $message = new message(0, $msg , $_SESSION['user']->getEmail(), getdate());
        $doa->saveMessage($message);
        break;

    case "messages":
        $res = $doa->getAllMessage();
        forEach($res as $row){
            $message= new message($row['id'], $row['message'], $row['sender'], $row['date']);
            echo $message->getSender()." ".$message->getDate()." :<br>".$message->getMessage()."<br><br>";
        }
        break;
}


?>