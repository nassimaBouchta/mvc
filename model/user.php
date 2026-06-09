<?php
class User{
    private $email;
    private $password;
    private $name;
    private $birthday;
    private $telephone;
    private $visibility;
    private $website;
    private $description;

    public function __construct($email,$password,$name,$birthday,$telephone,$visibility,$website,$description){
        $this->email=$email;
        $this->password=$password;
        $this->name=$name;
        $this->birthday=$birthday;
        $this->telephone=$telephone;
        $this->visibility = $visibility;
            $this->website = $website;
            $this->description = $description;
    }

       public function setEmail($email){
            $this->email = $email;
        }
        public function getEmail(){
            return $this->email;
        }
        
        public function setPassword($password){
            $this->password = $password;
        }
        public function getPassword(){
            return $this->password;
        }
        
        public function setName($name){
            $this->name = $name;
        }
        public function getName(){
            return $this->name;
        }
        
        public function setBirthday($birthday){
            $this->birthday = $birthday;
        }
        public function getBirthday(){
            return $this->birthday;
        }
        
        public function setTelephone($telephone){
            $this->telephone = $telephone;
        }
        public function getTelephone(){
            return $this->telephone;
        }
        
        public function setVisibility($visibility){
            $this->visibility = $visibility;
        }
        public function getVisibility(){
            return $this->visibility;
        }
        
        public function setWebsite($website){
            $this->website = $website;
        }
        public function getWebsite(){
            return $this->website;
        }
        
        public function setDescription($description){
            $this->description = $description;
        }
        public function getDescription(){
            return $this->description;
        }
        

}

?>