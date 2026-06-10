<?php
include "../model/user.php";

class UserDao{

     private $dbh;
    public function __construct(){
        try{
            $this->dbh = new PDO('mysql:host=localhost;dbname=test_db', "root","");
        }catch (PDOException $e) {
         print "Erreur !: " . $e->getMessage() . "<br/>";
         die();
        }
    }

    public function insertUser(User $user){
        $stm = $this->dbh->prepare("INSERT INTO user VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stm->bindValue(1, $user->getEmail());
        $stm->bindValue(2, $user->getPassword());
        $stm->bindValue(3, $user->getName());
        $stm->bindValue(4, $user->getBirthday());
        $stm->bindValue(5, $user->getTelephone());
        $stm->bindValue(6, $user->getVisibility());
        $stm->bindValue(7, $user->getWebsite());
        $stm->bindValue(8, $user->getDescription());
        $stm->bindValue(9, $user->getRole());
        
        $stm->execute();
    }

     public function loginUser($email, $password){
        
        $stm = $this->dbh->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        
        $stm->bindParam(1 ,$email);
        $stm->bindParam(2 ,$password);
        
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);
        $user = null;
        if(!empty($result)){
            $user = new User($result['email'],$result['password'],$result['name'],$result['birthdate'],$result['telephone'],$result['visibility'],$result['website'],$result['description'],$result['role'] );
           
        }
        return $user;
    
    }
}


?>