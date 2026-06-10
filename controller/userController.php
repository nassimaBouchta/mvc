<?php
include "../dao/userDao.php";

$action=$_GET['action'];
$dao=new UserDao();

switch($action){
    case 'insert':
        $vis=$_POST['visibility'];
$name=$_POST['name'];
$site=$_POST['site'];
$tel=$_POST['telephone'];
$mail=$_POST['email'];
$psw=$_POST['password'];
$bd=$_POST['birthdate'];
$desc=$_POST['description'];
        
        if(isset($mail, $psw, $name, $bd, $tel, $vis, $site, $desc)){
            $user = new User($mail, $psw, $name, $bd, $tel, $vis, $site, $desc);
            $dao->insertUser($user);
            header('location:../index.html');
        }
        break;
case 'login':

$email=$_POST['email'];
$pswd=$_POST['password'];

$user=$dao->loginUser($email,$pswd);
if ($user != null){
    session_start();
    $_SESSION['user']=$user;
    $_SESSION['role'] = $user->getRole();
    header('location: ../view/bienvenue.php');
        }else{
            echo "Login Failed!";
}

break;

case 'logout':
    session_start();
    unset($_SESSION['user']); 
    header('Location: ../view/login.html');

}



?>