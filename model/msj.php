<?php

class message{
        private $id;
        private $message;
        private $sender;
        private $date;

        public function __construct($id, $message, $sender, $date){
            $this->id = $id;
            $this->message = $message;
            $this->sender = $sender;
            $this->date = $date;
        }

        //id
        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id = $id;
        }
        //message
        public function getMessage(){
            return $this->message;
        }
        public function setMessage($message){
            $this->message = $message;
        }
        //sender
        public function getSender(){
            return $this->sender;
        }
        public function setSender($sender){
            $this->sender = $sender;
        }

        //date
        public function getDate(){
            return $this->date;
        }
        public function setDate($date){
            $this->date = $date;
        }

}

?>