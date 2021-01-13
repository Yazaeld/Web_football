<?php
/* Inclusion des fichiers utilisés */
require_once 'view/view.php';
require_once 'control/controller.php';
require_once 'model/Ligue1Builder.php';

/* Cette classe s'occupe des requêtes et permet de changer l'url courante afin d'appeler les fonctions du controller et de modifier la vue. */


    class Router{


      public function main(Ligue1Storage $store){

        session_start();
        $_SESSION["feedback"]=null;

        $view=new View($this,"");

        //$store->reinit();
        $ctrl=new Controller($view,$store);

        if(!key_exists("action",$_GET)){
        $ctrl->makeHomePage();
        }else{
          switch (key_exists('action',$_GET)){
            case $_GET["action"]==="Inscription":
              $ctrl->makeInscriptionPage();
              break;
            case $_GET["action"]==="Connexion":
              $ctrl->makeConnexionPage();
              break;
            case $_GET["action"]==="VerifInscription":
              $ctrl->verifInscription();
              break;
            case $_GET ["action"]==="VerifConnexion":
              $ctrl->verifConnexion();
              break;
            case  $_GET["action"]==="New":
              $ctrl->NewEquipe($_POST);
              break;
            case $_GET["action"]=="saveNewEquipe":
              $ctrl->saveNewEquipe();
              break;
            case $_GET["action"]==="User":
              $ctrl->makeUserPage();
              break;
            case $_GET["action"]==="listeEq":
              $ctrl->makeListePage();
              break;
            case $_GET["action"]==="deconnexion":
              $ctrl->deco();
              break;
            case $_GET["action"]==="EquipePage":
              $ctrl->makeEquipePage($_GET["id"]);
              break;
            case $_GET["action"]==="informations":
              $ctrl->makeinformationPage();
              break;
            case $_GET["action"]==="askDelete":
              $ctrl->askEquipeDeletion($_GET["id"]);
              break;
            case $_GET["action"]==="delete":
              $ctrl->makeDeletePage($_GET["id"]);
              break;
            case $_GET["action"]==="modifier":
              $ctrl->makeModifactionPage($_GET["id"]);
              break;
          }
      }
        $view->render();
      }

      public function getEquipeURL($id){
        return "?action=EquipePage&id=".$id;
      }

      public function getEquipeCreationURL(){
        return "?action=nouveau";
      }

      public function getEquipeSaveURL(){
        return "?action=SaveNewJeux";
      }

      public function getURLverifInscription(){
       return "?action=VerifInscription";
      }

      public function getURLverifConnexion(){
       return "?action=VerifConnexion";
      }

      public function deconnexion(){
        return "?action=deconnexion";
      }

      public function getUrlAskDelete($id){
        return "?action=askDelete&id=".$id;
      }

      public function getUrlModifier($id){
        return "?action=modifier&id=".$id;
      }

      public function getURLDelete($id){
        return "?action=delete&id=".$id;
      }
      public function POSTredirect($url, $feedback) {
              $_SESSION['feedback'] = $feedback;
              header("Location: ".htmlspecialchars_decode($url), true, 303);
      }


    }
 ?>
