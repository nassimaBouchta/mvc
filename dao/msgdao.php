<?php
include '../model/msg.php';

class messageDOA{
    private $con;

    public function __construct(){
        try{
            $this->con = new PDO('mysql:host=localhost;dbname=test_db', "root", "");
        }catch(PDOException $e){
            print "Error !: ". $e->getMessage(). "<br>";
            die();
        }
    }


    public function saveMessage(message $message){
        $req = $this->con->prepare("INSERT INTO message (message, sender, date) VALUES (?, ?, NOW())");
        $req->bindValue(1, $message->getMessage());
        $req->bindValue(2, $message->getSender());
        $req->execute();
    }

    public function getAllMessage(){
        $req = $this->con->prepare("SELECT * FROM message ORDER BY date");
        $req->execute();
        $res= $req->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

  



}


?>