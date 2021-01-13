<?php
   /* Inclusion des fichiers utilisés */
    require_once 'model/Ligue1.php';
    require_once 'model/User.php';
    
    /*On possède une interface afin de définir toutes les fonctions qi nous serviront pour l'accès aux bdd afin de créer ou de recupérer un Utilisateur ou une équipe*/
    
    interface Ligue1Storage{
      public function createUser(User $u);
      public function AllUsers();
      public function createEquipe(Ligue1 $j);
      public function AllEquipeByUser($nomuser);
      public function AllEquipe();
      public function getImageByEquipe($nom);
      public function AjoutImage($nom,$nomuser,$img);
      public function AjoutEquipeUser($nom,$nomuser);
      public function EquipeByNom($nom);
      public function AllImageUser($nomuser);
      public function delete($nom);
      public function Modification(Ligue1 $j,$nom);
    }


 ?>
