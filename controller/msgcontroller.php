<?php
include '../dao/msgdao.php';
include '../model/user.php';
session_start();
$action = $_GET['action'];

$doa = new messageDOA();

switch($action){
    case "send":
        $msg = $_POST['message'];
       if (!isset($_SESSION['user'])) { http_response_code(403); exit; }
        $message = new message(0, $msg, $_SESSION['user']->getEmail(), null);
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