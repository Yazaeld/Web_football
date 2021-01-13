<?php
    /* Inclusion des fichiers utilisés */
    require_once 'model/User.php';

    /* Ici, la classe nous permet de construire un utilisateur. User.php définit un utilisateur et la création se passe ici.
    Il y a aussi des fonctions de test afin de vérifier si les informations pour l'inscription sont valides ou bien si les informations de connexion sont valides*/

    class UserBuilder{
        private $data;
        private $error;
        private $NOMUSER_REF;
        private $PASS_REF;
        private $MAIL_REF;
        private $Tmppass;


        public function __construct($tab=null){
          if ($tab === null) {
            $tab = array(
              "nomuser" => "",
              "pass" =>"",
              "confirmpass"=>"",
              "mail"=>""
            );
          }
          $this->data=$tab;
          $this->error = array();

          $this->NOMUSER_REF=$tab["nomuser"];
          $this->PASS_REF=$tab["pass"];
          $this->MAIL_REF=$tab["mail"];
          $this->Tmppass=$tab["confirmpass"];
        }

        public function getData(){
          return $this->data;
        }

        public function getNomuser(){
          return $this->NOMUSER_REF;
        }

        public function getPass(){
          return $this->PASS_REF;
        }

        public function getMail(){
          return $this->MAIL_REF;
        }

        public function getError($ref) {
          return key_exists($ref, $this->error)? $this->error[$ref]: null;
        }

        public function createUser(){
          if (!key_exists("nomuser", $this->data) || !key_exists("pass", $this->data)|| !key_exists("mail", $this->data))
              throw new Exception("Manque paramètre pour la création d'un Utilisateur");
          return new User($this->data["nomuser"], $this->data["pass"],$this->data["mail"]);
        }

        /* Regarde si les champs lors de l'inscription sont valide */
        public function isValid() {
            if(!key_exists("nomuser", $this->data) || $this->data["nomuser"] === ""){
              $this->error["nomuser"] = "Vous devez entrer un nom d'utilisateur !";
            }else if (!key_exists("pass", $this->data) ||  $this->data["pass"] === ""){
              $this->error["pass"] = "Vous devez entrer un mot de passe ! ";
            }else if($this->Tmppass!=$this->PASS_REF ){
               $this->error["confirmpass"]="Les mots de passe ne sont pas identiques.";
            }else if(!key_exists("mail", $this->data) || $this->data["mail"] === ""){
              $this->error["mail"] = "Vous devez entrer un mail !";
            }
            return count($this->error) === 0;
        }

         /* Regarde si les champs lors de la connexion sont valide */
        public function isValidConnexion($tab){
          if(count($tab)==0 || !key_exists("nomuser", $this->data)|| $this->data["nomuser"] === ""){
                $this->error["nomuser"]="Le nom d'Utilisateur n'existe pas.";
          }else{
              $pass=explode("[ ]",$tab["Pass"]);
              if (!key_exists("pass", $this->data) ||  $this->data["pass"] === ""){
                echo 'ici';
                $this->error["pass"] = "Vous devez entrer un MOT DE PASSE";
            }else if(!password_verify($this->PASS_REF,$pass[0])){
                $this->error["pass"]="Le mot de passe est incorrect.";
              }
          }
          return count($this->error) === 0;
          }
  }
?>
