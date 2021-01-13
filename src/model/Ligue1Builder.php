<?php
  /* Inclusion des fichiers utilisés */
    require_once 'model/Ligue1.php';

    /*L'instance nous premet de créer un objet Ligue1 qui est un club elle possède tous les accesseurs nécessaires. De plus, un fonction peremet de tester si l'upload d'image est valide (grâce à son extension). Enfin il y a une dernier fonction afin de valider si les champs remplis respectent certaines conditions */

    class Ligue1Builder{
        private $data;
        private $error;
        private $NOM_REF;
        private $DATE_REF;
        private $STADE_REF;
        private $ENTRAINEUR_REF;
        private $PRESIDENT_REF;

        public function __construct($tab=null){
          if ($tab === null) {
            $tab = array(
              "nom" => "",
              "date" =>0,
              "stade"=>"",
               "entraineur"=>"" ,
              "president"=>""
            );
          }
          $this->data=$tab;
          $this->error = array();

          if(key_exists("Nom",$tab)){
            $this->NOM_REF=$tab["Nom"];
          }else{
            $this->NOM_REF=$tab["nom"];
          };

          if(key_exists("Date",$tab)){
            $this->DATE_REF=$tab["Date"];
          }

          if(key_exists("Stade",$tab)){
            $this->STADE_REF=$tab["Stade"];
          }else{
            $this->STADE_REF=$tab["stade"];
          }

          if(key_exists("Entraineur",$tab)){
             $this->ENTRAINEUR_REF=$tab["Entraineur"];
          }else{
             $this->ENTRAINEUR_REF=$tab["entraineur"];
          }

          if(key_exists("President",$tab)){
              $this->PRESIDENT_REF=$tab["President"];
          }else{
              $this->PRESIDENT_REF=$tab["president"];
          }
        }

        public function getData(){
          return $this->data;
        }

        public function getNom(){
          return $this->NOM_REF;
        }

        public function getDate(){
          return $this->DATE_REF;
        }

        public function getStade(){
          return $this->STADE_REF;
        }

        public function getEntraineur(){
          return $this->ENTRAINEUR_REF;
        }

        public function getPresident(){
            return $this->PRESIDENT_REF;
        }

        public function createEquipe(){
            if (!key_exists("nom", $this->data) || !key_exists("date", $this->data)|| !key_exists("stade", $this->data)|| !key_exists("entraineur", $this->data) || !key_exists("president",$this->data))
              throw new Exception("Il manque des paramètres afin de créer l'équipe");
              return new Ligue1($this->data["nom"], $this->data["date"],$this->data["stade"],$this->data["entraineur"],$this->data["president"]);
        }

        public function getError($ref) {
          return key_exists($ref, $this->error)? $this->error[$ref]: null;
        }

        public function Upload(){
            if($_FILES["Image"]!="" && $_FILES['Image']['error'] == 0) {
                $extensions = array(
                  IMAGETYPE_JPEG => '.jpg',
                  IMAGETYPE_PNG => '.png',
                  IMAGETYPE_BMP => '.bmp',
                );
                //Vérification des extensions
                $format = exif_imagetype($_FILES['Image']['tmp_name']);
                if ($format !== false) {
                  if (key_exists($format,$extensions)) {
                    $nom_image =$_FILES['Image']["name"];
                    if (!move_uploaded_file($_FILES['Image']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/dm-inf6c-2019/upload/". $nom_image)) {
                      $this->error["image"]='Problème de copie de fichier';
                  }
                } else {
                  $this->error["image"]= 'Ce n’est pas une image !';
                }
              }
          }
        return key_exists("image",$this->error);
        }

        public function isValid() {
            if (!key_exists("nom", $this->data) || $this->data["nom"] === ""){
              $this->error["nom"] = "Merci de rentrer le nom de l'équipe";
            }else if (mb_strlen($this->data["nom"], 'UTF-8') >= 50){
              $this->error["nom"] = "Le nom de l'équipe ne peut excéder 50 caractères";
            }else if (!key_exists("date", $this->data) || $this->data["date"] === "" || $this->data["date"]<1850){
              $this->error["date"] = "Merci de rentrer la date de création du club / Attention la date de création du club ne peut être avant 1850";
            }else if(!key_exists("stade", $this->data) || $this->data["stade"] === ""){
              $this->error["stade"] = "Merci de rentrer un stade";
            }else if (mb_strlen($this->data["stade"], 'UTF-8') >= 50){
                $this->error["stade"] = "Le nom du stade ne peut excéder 50 caractères";
            }else if(!key_exists("entraineur", $this->data) || $this->data["entraineur"] === ""){
                $this->error["entraineur"] = "Merci de rentrer un entraineur";
            }else if (mb_strlen($this->data["nom"], 'UTF-8') >= 50){
                $this->error["entraineur"] = "Le nom de l'entraineur ne peut excéder 50 caractères";
            }else if(!key_exists("president", $this->data) || $this->data["president"] === ""){
                $this->error["president"] = "Merci de rentrer un president";
            }else if (mb_strlen($this->data["nom"], 'UTF-8') >= 50){
                $this->error["president"] = "Le nom du président ne peut excéder 50 caractères";
            }
            $this->Upload();
            return count($this->error) === 0;
      }

    }
?>
