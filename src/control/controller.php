<?php

  /* Inclusion des fichiers utilisé */
  require_once ("model/Ligue1.php");
  require_once("model/Ligue1Storage.php");
  require_once("model/Ligue1Builder.php");
  require_once("model/UserBuilder.php");
  require_once("view/view.php");


/* Ici notre controller possède comme attributs une view et un "storage" qui permet de faire le lien avec nos bdd
Son but étant de controler les actions du site de plus une vérification xss est effectuée afin d'éviter des problèmes de sécurité comme une alerte js intempestive
Le choix d'afficher la vue pour un utilisateur connecté ou non connecté se passe ici aussi. */

    class Controller{
        public $view;
        public $storage;
        public $currentStorage;
        protected $currentColorBuilder;
        protected $modifiedColorBuilders;
      public function __construct($v,Ligue1Storage $store){
          $this->view=$v;
          $this->storage=$store;
          $this->currentColorBuilder = key_exists('currentColorBuilder', $_SESSION) ? $_SESSION['currentColorBuilder'] : null;
          $this->modifiedColorBuilders = key_exists('modifiedColorBuilders', $_SESSION) ? $_SESSION['modifiedColorBuilders'] : array();
      }
      public function __destruct() {
          $_SESSION['currentColorBuilder'] = $this->currentColorBuilder;
          $_SESSION['modifiedColorBuilders'] = $this->modifiedColorBuilders;
	     	}

      public function makeHomePage(){
          $data=$this->storage->AllEquipe();
          $dataimg=array();
          foreach ($data as $key => $value) {
              $tab=$this->storage->getImageByEquipe($value["Nom"]);
              $dataimg[$value["Nom"]]=$tab["image"];
          }
          $this->view->HomePage($data,$dataimg);
        }

      public function makeConnexionPage(){
        $this->view->ConnexionPage();
      }

      public function makeInscriptionPage(){
        $this->view->InscriptionPage();
      }

      public function makeUnknownEquipePage(){
        $this->view->UnknownEquipePage();
      }

      public function makeEquipePage($nom){
        $data=$this->storage->EquipeByNom($nom);
        if($data!=false){;
          $dataimg=$this->storage->getImageByEquipe($nom);

          if(key_exists("session",$_SESSION)){

            $equipe=$this->storage->AllEquipeByUser($_SESSION["session"]);
            $tab=array();
            $droit=false;
            $i=0;
            foreach ($equipe as $key => $value) {
              $tab[$i]=$value["Nom"];
              $i=$i+1;
            }
            for($j=0;$j<count($tab);$j++){
              if($data["Nom"]===$tab[$j])
                $droit=true;
            }
            $this->view->EquipePage($data,$dataimg,$this->view->menu,$droit);
          }else{
            $this->view->EquipePage($data,$dataimg,$this->view->menu2,false);
          }
        }else{
         makeUnknownEquipePage();
        }
      }

      public function makeUserPage(){
          if(key_exists("session",$_SESSION)){
                if(count($this->storage->AllEquipeByUser($_SESSION["session"]))==0){
                  $this->view->UserPage(array(),array());
                }else{
                  $data=$this->storage->AllEquipeByUser($_SESSION["session"]);
                  $dataimg=array();
                  foreach ($data as $key => $value) {
                    $tab=$this->storage->getImageByEquipe($value["Nom"]);
                    $dataimg[$value["Nom"]]=$tab["image"];
                  }
                  $this->view->UserPage($data,$dataimg);
                }
          }else{
            $this->makeHomePage();
          }
      }

      public function makeListePage(){
        if(key_exists("session",$_SESSION)){
            $data=$this->storage->AllEquipe();
            $dataimg=array();
            foreach ($data as $key => $value) {
              $tab=$this->storage->getImageByEquipe($value["Nom"]);
              $dataimg[$value["Nom"]]=$tab["image"];
            }
            $this->view->listeEquipe($data,$dataimg);
        }else{
            $this->makeHomePage();
        }
      }

      public function verifConnexion(){
        $_POST["mail"]="";
        $_POST["confirmpass"]="";

        $u=new UserBuilder($_POST);
        $all=$this->storage->AllUsers();
        $tab=array();
        foreach($all as $key => $value){
          if($value["Nomuser"]===$_POST["nomuser"]){
            $tab=$value;
          }
        }
        if($u->isValidConnexion($tab)){
          $_SESSION["session"]=$tab["Nomuser"];
          $this->makeUserPage();
        }else{
          $this->view->feed="Erreur dans le formulaire !!!";
          $this->view->getConnexionForms($u);
        }
      }

      public function verifInscription(){
        $u=new UserBuilder($_POST);
        if($u->isValid()){
          $user=new User(htmlspecialchars($_POST["nomuser"]),$_POST["pass"],htmlspecialchars($_POST["mail"]));
          $this->storage->createUser($user);
          $_SESSION["session"]=$_POST["nomuser"];
          $this->makeUserPage();
        }else{
           $this->view->feed="Erreur dans le formulaire !!!";
           $this->view->getInscriptionForms($u);
        }
      }

      public function deco(){
        session_unset();
        $this->makeHomePage();
      }

  		public function newEquipe() {
        if(key_exists("session",$_SESSION)){
            $this->view->NewEquipePage();

        }else{
            $this->makeHomePage();
  		  }
      }

  		public function saveNewEquipe(){
        if(key_exists("session",$_SESSION)){
            $build=new Ligue1Builder($_POST);
            if($build->isValid()){
                  $this->storage->AjoutImage($_POST["nom"],$_SESSION["session"],$_FILES["Image"]["name"]);
                  $this->storage->AjoutEquipeUser($_POST["nom"],$_SESSION["session"]);
                  $equipe=new Ligue1(htmlspecialchars($_POST["nom"]),$_POST["date"],htmlspecialchars($_POST["stade"]),htmlspecialchars($_POST["entraineur"]),htmlspecialchars($_POST["president"]));
                  $this->storage->createEquipe($equipe);
                   $this->makeUserPage();
            }else{
                  $this->view->feed="Erreur dans le formulaire !!!";
                  $this->view->getEquipeForms($build);
            }

        }else{
          $this->makeHomePage();
        }
      }

      public function makeinformationPage(){
        if(key_exists("session",$_SESSION)){
          $this->view->InformationPage($this->view->menu);
        }else{
          $this->view->InformationPage($this->view->menu2);
        }
      }


      public function askEquipeDeletion($id){
        if(key_exists("session",$_SESSION)){
          $tab=$this->storage->AllEquipe();
          $AllEquipe=array();
          $i=0;
          foreach ($tab as $key => $value) {
            $AllEquipe[$i]=$value['Nom'];
            $i=$i+1;
          }
          $rep=false;
          for($j=0;$j<$i;$j++){
            if($id===$AllEquipe[$j]){
              $rep=true;
            }
          }
          if($rep){
            $this->view->makeEquipeDeletionPage($id);
          }else{
           makeUnknownEquipePage();
         }

        }else{
          $this->makeHomePage();
        }
      }

      public function makeDeletePage($nom){
        if(key_exists("session",$_SESSION)){
              $this->storage->delete($nom);
              $this->makeUserPage();
        }else{
            $this->makeHomePage();
        }
      }

      public function makeModifactionPage($nom){
        if(key_exists("session",$_SESSION)){
          $data=$this->storage->EquipeByNom($nom);
          $this->storage->delete($nom);
          $builder=new Ligue1Builder($data);
          $this->view->ModificationPage($builder);
        }else{
          $this->makeHomePage();
        }
      }

}
 ?>
