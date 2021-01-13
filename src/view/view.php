<?php
/* Les fichiers utilisés */
require_once ('model/Ligue1.php');
require_once ('Router.php');

class View{
    public $title;
    public $content;
    public $router;
    public $menu;
    public $menu2;
    public $feed;
    public $titre="Ligue 1 - DM WEB";

    public function __construct($router,$feed){
        $this->router=$router;
        $this->menu=array("Mes équipes"=>"?action=User","Les équipes sur le site"=>"?action=listeEq","Ajouter une équipe"=>"?action=New","A propos"=>"?action=informations");
        $this->menu2=array("Accueil"=>"Ligue1.php","A propos"=>"?action=informations");
        $this->feedback=$feed;
        $this->lienjs="";
        $this->title="DM Web ".$this->titre;
        $this->feed=$feed;
    }

    public function render(){
        $res="";
        $res.="<!doctype html>";
        $res.='<html lang="fr">';
        $res.="<head>";
        $res.='<meta charset="utf-8"/>';
        $res.='<title>'.$this->title.'</title>';
        $res.='<link rel="stylesheet" type="text/css" href="src/style/style.css" />';
        +

        $res.='</script><script defer src="src/javascript/Ballon.js"> echo "init()";</script>';
        $res.='</head>';
        $res.="<body>";
        $res.='<div id="presentation">';
        $res.='<h1>'.$this->titre.'</h1><br>';
        $res.=$this->content;
        $res.='<footer>
                          <div id="footer" >'.
                          "<b>".$this->titre."</b>
                              <p>&copy; Copyright 2019 ".$this->titre.", Fait pour l'université de Caen. Les images sont utilisées à but uniquement scolaire, les sources dans l'onglet \"A propos\"</p>
                              <p>Site créé par 21505592 et 21403532</p>
                           </div>".'
                      </footer>';
        $res.="</body>";
        $res.="</html>";
        echo $res;
    }

/* Notre fonction représentant la page d'accueil */
    public function HomePage($data,$dataimg){
        $this->content="<nav><ul class='menu2'>" ;
        foreach($this->menu2 as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul></nav>';
        $this->content.='
                  <form method="GET" id="co">
                  <input type="submit" name="action" value="Inscription">
                  <input type="submit" name="action" value="Connexion">
                  </form>
                    ';

        $this->content.='<p class="desc">Le championnat de France de football est nommé « Ligue 1 » et se compose de 20 équipes professionnelles. Il se déroule tout au long de l’année (de l’été jusqu’au printemps suivant), en faisant s’affronter ces 20 clubs avec des matchs allers et retours. Donc, au total, une équipe se voit jouer 38 matchs durant une saison. Ce championnat fut créé en 1932 et le premier match de l’histoire de cette ligue se déroula le 11 septembre de cette même année. Il fait partie aujourd’hui des 5 plus grands championnats d’Europe de football. Un classement est fait en fonction des matchs joués chaque week-end, 3 points sont accordés pour une défaite, 1 point pour un match nul et 0 point pour une défaite. Dû à son ancienneté, ce championnat détient plusieurs records en fonction des équipes qui le composent tels que : </p>
                  <ul class="records">
                    <li>Plus grand nombre de saisons disputées en Ligue 1 : 68 saisons (Olympique de Marseille)</li>
                    <li>Plus grand nombre de saisons consécutives en L1 : 45 saisons (Paris Saint-Germain)</li>
                    <li>Plus grand nombre de titres : 10 titres (Saint-Etienne)</li>
                    <li>Plus grand nombre de titres consécutifs : 7 titres (Olympique Lyonnais)</li>
                    <li>Plus grand nombre de points sur une saison : 96 points (Paris Saint-Germain en 2015-2016)</li>
                    <li>Plus petit nombre de points sur une saison : 17 points (RC Lens 1988-1989)</li>
                  </ul>';

        $this->content.='<h2 id="equipes">Toutes les équipes de Ligue 1</h2>
                      <br/>
                      <ul>';
        foreach($data as $key => $value) {
            $this->content.='<li class="listeEq">';
            $this->content.='<a class ="nomEq" href="'.$this->router->getEquipeURL($value["Nom"]).'">';
            if($dataimg[$value["Nom"]]==""){
                $this->content.='<img class=RedimensionnerIm src="https://'.$_SERVER['SERVER_NAME'].'/dm-inf6c-2019/src/image_notfound/notfound.png" alt="miniature" /><br/>';
            }else{
                $this->content.='<img class=RedimensionnerIm src="upload/'.$dataimg[$value["Nom"]].'" alt="miniature" /><br/>';
            }
            $this->content.=$value["Nom"].'</a></li>';
        }

        $this->content.='</ul><br><br>';
    }

/* Fonction représentant la page de connexion d'un utilisateur après avoir cliqué sur "connexion" */
    public function ConnexionPage(){
        $this->content="<nav><ul class='menu2'>" ;
        foreach($this->menu2 as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul></nav>';
        $this->content.='<br>
                  <form method="post" action="'.$this->router->getURLverifConnexion().' ">
                    <fieldset>
                    <legend> Connexion </legend>
                      <br/>
                      <label class="Text">Pseudo :<input type="text" name="nomuser" /></label><br/>
                      <label class="Text">Mot de passe :<input type="password" name="pass" /></label><br/>
                      <input type="submit" value="Connexion" />
                    </fieldset>
                  </form>';
    }

/* Fonction représentant la page d'inscription d'un utilisateur après avoir cliqué sur "inscription" */
    public function InscriptionPage(){
        $this->content="<nav><ul class='menu2'>" ;
        foreach($this->menu2 as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul></nav>';
        $this->content.='<br><form method="post" action='.$this->router->getURLverifInscription().'>
                          <fieldset>
                            <legend> Inscription </legend>
                            <br/>
                          <label class="Text">Pseudo :<input type="text" name="nomuser"  /> </label><br/>
                          <label class="Text">Mot de passe :<input type="password" name="pass" /></label><br>
                          <label class="Text">Confirmer votre mot de passe :<input type="password" name="confirmpass" /></label><br>
                          <label class="Text">Adresse mail :<input type="email" name="mail" /></label><br>
                        <br>
                        <input type="submit" value="Inscription" />
                        </fieldset>
                      </form>';
    }

/* Fonction représentant la page de connexion d'un utilisateur après avoir cliqué sur "connexion" */
    public function UserPage($data,$dataimg){
        $this->content="<nav><ul>";
        foreach($this->menu as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul></nav>
                <form action="'.$this->router->deconnexion().'" method="post">
                      <input id="deco" type="submit" name="logout" value="Déconnexion"/>
                </form><br>
                <br>
                <h2> Mes équipes </h2><br/><ul>';
        if($data!=array() && $dataimg != array()){
            foreach($data as $key => $value) {
                $this->content.='<li class="listeEq">';
                $this->content.='<a class ="nomEq" href="'.$this->router->getEquipeURL($value["Nom"]).'">';
                if($dataimg[$value["Nom"]]==""){
                    $this->content.='<img class=RedimensionnerIm src="https://'.$_SERVER['SERVER_NAME'].'/dm-inf6c-2019/src/image_notfound/notfound.png" alt="miniature" /><br/>';
                }else{
                    $this->content.='<img class=RedimensionnerIm src="upload/'.$dataimg[$value["Nom"]].'" alt="miniature" /><br/>';
                }
                $this->content.=$value["Nom"].'</a></li>';
            }
        }
        $this->content.="</ul>";
    }

/* Fonction représentant la page des informations d'un club après que l'on ai cliqué dessus */
    public function EquipePage($data,$dataimg,$Menu,$droit){
        $this->content='<nav><ul>';
        foreach($Menu as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul></nav>';
        if($Menu==$this->menu){
            $this->content.='<form action="'.$this->router->deconnexion().'" method="post">
                            <input id="deco" type="submit" name="logout" value="Déconnexion"/>
                            </form><br/><br/>';
        }
        $this->content.='<br/><h2>'.$data['Nom'].'</h2>';
        if($dataimg["image"]==""){
            $this->content.='<img class="logoEq" src="https://'.$_SERVER['SERVER_NAME'].'/dm-inf6c-2018/src/image_notfound/notfound.png" alt="miniature" /><br/>';
        }else{
            $this->content.='<img class="logoEq" src="upload/'.$dataimg['image'].'" alt="image">';
        }
        $this->content.='<h2 class="infos">Date de création du club</h2>
                    <p class="informations">'.$data['Date'].'</p>
                    <h2 class="infos">Stade actuel</h2>
                    <p class="informations">'.$data["Stade"].'</p>
                    <h2 class="infos">Entraineur actuel </h2>
                    <p class="informations">'.$data["Entraineur"].'</p>
                    <h2 class="infos">Président</h2>
                    <p class="informations">'.$data["President"].'</p><br/>';
        if($droit){
            $this->content.='<form action="'.$this->router->getUrlModifier($data['Nom']).'" method="post">
                    <input type="submit" name="Modifier" value="Modifier" /></form>
                            <form action="'.$this->router->getUrlAskDelete($data['Nom']).'" method="post">
                            <input type="submit" name="supprmier" value="Supprimer"/></form><br/><br/>';
        }
    }

/* Fonction représentant la page indiquant à l'utilisateur que cette équipe est inconnue */
    public function UnknownEquipePage(){
        $this->content="<nav><ul class='menu2'>" ;
        foreach($this->menu2 as $nom => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$nom.'</a></li>';
        }
        $this->content.='</ul></nav>';
        $this->content.='<br/><span id="inco">EQUIPE INTROUVABLE/INCONNUE ! </span>';
    }

/* Fonction représentant le formulaire de la page d'ajout d'une équipe */
    public function getEquipeForms(Ligue1Builder $a){
        $tab=$a->getData();
        $this->content="<nav><ul>" ;
        foreach($this->menu as $nom => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$nom.'</a></li>';
        }
        $this->content.='</ul>
                        </nav>
                        <form action="'.$this->router->deconnexion().'" method="post">
                        <input id="deco" type="submit" name="logout" value="Déconnexion"/>
                          </form>
                          <div class="feedback">'.$this->feed.'</div>
                          <br>
                          <form enctype="multipart/form-data" method="post" action='.$this->router->getEquipeSaveURL().'>
                            <fieldset>
                            <legend>Ajouter une équipe </legend>
                            <br/>
                              <label>Nom du club :<input type="text" name="nom"  value="'.$this->htmlesc($tab["nom"]).'"/></label><br/><br/>';
        $error = $a->getError("nom");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }
        $this->content.="</label><br/>";
        $this->content.='<label>Date de création du club :<input type="text" name="date"  value="'.$this->htmlesc($tab["date"]).'"/></label><br><br/>';
        $error = $a->getError("date");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }

        $this->content.="</label><br/>";
        $this->content.='<label>Stade actuel :<input type="text" name="stade"  value="'.$this->htmlesc($tab["stade"]).'"/></label><br><br/>';
        $error = $a->getError("stade");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }

        $this->content.="</label><br/>";
        $this->content.='<label>Entraineur actuel :<input type="text" name="entraineur"  value="'.$this->htmlesc($tab["entraineur"]).'"/></label><br><br/>';
        $error = $a->getError("entraineur");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }

        $this->content.="</label><br/>";
        $this->content.='<label>President actuel :<input type="text" name="president"  value="'.$this->htmlesc($tab["president"]).'"/></label><br><br/>';
        $error = $a->getError("president");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }


        $this->content.='</label><br/>
                              <br/>
                              <label>Ajouter une image :  <input class="ajoutImage" type="file" name="Image"></label><br/>';
        $error = $a->getError("image");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }
        $this->content.='</label><br/>';
        $this->content.='
                              <br/>
                              <input class="Boutonajout" type="submit" value="Ajouter le club" />
                              </fieldset>
                          </form>
                            <br><br>';
    }

/* Fonction représentant le formulaire de la page d'inscription d'un utilisateur non connecté */
    public function getInscriptionForms(UserBuilder $u){
        $tab=$u->getData();
        $this->content="<nav><ul class='menu2'>" ;
        foreach($this->menu2 as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul></nav>';
        $this->content.='<div class="feedback">'.$this->feed.'</div>';
        $this->content.='<br>
                  <form method="post" action="'.$this->router->getURLverifInscription().' ">
                    <fieldset>
                    <legend> Inscription </legend>
                      <br/>';

        $this->content.='<label class="Text">Pseudo<input type="text" name="nomuser" value="'.$this->htmlesc($tab["nomuser"]).'" /></label><br/>';
        $error = $u->getError("pass");
        if ($error !== null){
            $this->content.= '<span class="erreur">' .$error.'</span><br/>';
        }

        $this->content.="</label><br/>";
        $this->content.=' <label class="Text">Mot de passe<input type="password" name="pass" value="'.$this->htmlesc($tab["pass"]).'" /></label><br/>';
        $error = $u->getError("pass");
        if ($error !== null){
            $this->content.= '<span class="erreur">' .$error.'</span><br/>';
        }
        $this->content.="</label><br/>";
        $this->content.=' <label class="Text">Retapez votre mot de passe<input type="password" name="confirmpass" value="'.$this->htmlesc($tab["confirmpass"]).'" />';
        $error = $u->getError("confirmpass");
        if ($error !== null){
            $this->content.= '<span class="erreur">' .$error.'</span><br/><br/>';
        }
        $this->content.="</label><br/>";
        $this->content.='<label class="Text">Adresse mail<input type="email" name="mail" value="'.$this->htmlesc($tab["mail"]).'" /></label><br/>';
        $error = $u->getError("mail");
        if ($error !== null){
            $this->content.= '<span class="erreur">' .$error.'</span><br/>';
        }
        $this->content.="</label><br/>";
        $this->content.='<input type="submit" value="Inscription" />
                          </fieldset>
                        </form>';
    }

/* Fonction représentant le formulaire de la page de connexion d'un utilisateur non connecté */
    public function getConnexionForms(UserBuilder $u){
        $tab=$u->getData();
        $this->content="<nav><ul class='menu2'>" ;
        foreach($this->menu2 as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul></nav>';
        $this->content.='<div class="feedback">'.$this->feed.'</div>';
        $this->content.='<br>
                  <form method="post" action="'.$this->router->getURLverifConnexion().' ">
                    <fieldset>
                    <legend> Connexion </legend>
                        <br/>';
        $this->content.='<label class="Text">Pseudo<input type="text" name="nomuser" value="'.$this->htmlesc($tab["nomuser"]).'" />';
        $error = $u->getError("nomuser");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }
        $this->content.="</label><br/>";

        $this->content.=' <label class="Text">Mot de passe<input type="password" name="pass" value="'.$this->htmlesc($tab["pass"]).'" />';
        $error = $u->getError("pass");
        if ($error !== null){
            $this->content.= '<span class="erreur">'.$error.'</span><br/>';
        }
        $this->content.="</label><br/>";
        $this->content.='<input type="submit" value="Connexion" /> </fieldset> </form>';
    }

/* Fonction représentant la page de confirmation de la suppression d'un club */
    public function makeEquipeDeletionPage($id){
        $this->content='<h2>Supprimer un club du site</h2><br>
                <form action="'.$this->router->getURLDelete($id).'" method=POST>
                  <input class="Boutons" type="submit" name="supprmier" value="Supprimer le club"/>
                </form>
                 <form action="?action=User" method=POST>
                   <input class="Boutons" type="submit" name="submit" value="Retour à votre page d'."'".'Accueil"/>
                </form>';
    }

/* Fonction représentant la page d'ajout d'une nouvelle équipe */
    public function NewEquipePage(){
        $this->content="<nav><ul>" ;
        foreach($this->menu as $titre => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$titre.'</a></li>';
        }
        $this->content.='</ul>
                        </nav>
                        <form action="'.$this->router->deconnexion().'" method="post">
                        <input id="deco" type="submit" name="logout" value="Déconnexion"/>
                          </form>
                          <form enctype="multipart/form-data" method="post" action='.$this->router->getEquipeSaveURL().'>
                            <fieldset>
                            <legend> Ajouter un club </legend>
                            <br/>
                              <label>Nom du club :<input type="text" name="nom" /></label><br/><br/>
                              <label>Date de création du club :<input type="text" name="date" /></label><br/><br/>
                              <label>Stade actuel :<input type="text" name="stade" /></label><br/><br/>


                              <label>Entraineur actuel :<input type="text" name="entraineur"/></label><br/><br/>
                              <label>President actuel :<input type="text" name="president" /></label><br/><br/>


                              <label>Ajouter une image :  <input class="ajoutImage" type="file" name="Image"></label><br/>
                              <br/>
                              <input class="Boutonajout" type="submit" value="Ajouter une équipe" />
                              </fieldset>
                          </form>
                            <br><br>';
    }

/* Fonction représentant la page de toutes les équipes sur le site */
    public function listeEquipe($data,$dataimg){
        $this->content="<nav><ul>";
        foreach($this->menu as $nom => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$nom.'</a></li>';
        }
        $this->content.='</ul>
                    </nav>
                    <form action="'.$this->router->deconnexion().'" method="post">
                    <input id="deco" type="submit" name="logout" value="Déconnexion"/>
                      </form>
                    <br>
                    <br>
                    <h2> Toutes les équipes de '.$this->titre.' </h2>
                    <br/>
                    <ul>';
        foreach($data as $key => $value) {
            $this->content.='<li class="listeEq">';
            $this->content.='<a class ="nomEq" href="'.$this->router->getEquipeURL($value["Nom"]).'">';
            if($dataimg[$value["Nom"]]==""){
                $this->content.='<img class=RedimensionnerIm src="https://'.$_SERVER['SERVER_NAME'].'/dm-inf6c-2018/src/image_notfound/notfound.png" alt="miniature" /><br/>';
            }else{
                $this->content.='<img class=RedimensionnerIm src="upload/'.$dataimg[$value["Nom"]].'" alt="miniature" /><br/>';
            }
            $this->content.=$value["Nom"].'</a></li>';
        }
    }

/* Fonction représentant la page A propos */
    public function InformationPage($tab){
        $this->content="<nav class='menu2'><ul>";
        foreach($tab as $nom => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$nom.'</a></li>';
        }
        $this->content.="</ul></nav>";
        if(key_exists("Mes équipes",$tab)){
            $this->content.='
	                    <form action="'.$this->router->deconnexion().'" method="post">
	                    <input id="deco" type="submit" name="logout" value="Déconnexion"/>
	                      </form>
	                    <br>
	                    <br>';
        }

        $this->content.="<h2>Ce site sur la ligue 1 a été réalisé par :</h2>
                          <ul>
                            <li>21505592</li>
                            <li>21403532</li>
                          </ul>
                          <h2>Informations sur le site</h2>
                          <p>Ce site liste tous les clubs de footbal présents en Ligue 1, il est possible par un utilisateur connecté, d'ajouter et de voir tous les clubs ajoutés par lui ou d'autres utilisateurs. Il existe deux catégories de visiteurs, ceux non-connectés qui ne peuvent voir que la page Accueil et A propos. Et une catégorie utilisateur connecté qui peut ajouter, voir tous les clubs ajoutés et supprimer les clubs qu'il a ajouté. Ils peuvent supprimer uniquement les clubs qu'ils ont eux-mêmes ajoutés mais pas ceux des autres, ni ceux de ligue 1 car c'est l'admin qui en est le propriétaire. Grâce à une base de données, un utilisateur peut s'inscrire et ensuite se connecter librement, pas besoin de s'inscrire à chaque fois. Nous avons essayé de traiter au maximum les fuites de sécurité pour le mot de passe de chaque utilisateur.<br>
                          Les couleurs de ce site ont été choisi en fonction d'une palette de couleur sur ".'<a target="_blank" href="https://coolors.co">ce site.</a>
                          Toutes les images des logos des clubs de football ont été pris <a target="_blank" href="https://www.wikipedia.org">ici</a> et <a target="_blank" href="https://www.google.fr/imghp?hl=fr&tab=wi&authuser=0">ici.</a><br>
                          Nous avons eu quelques difficultés à la mise en place de l\'architecture MVCR et avons perdu beaucoup de temps dessus... Nous souhaitions citer les sources suivantes pour l\'aide qu\'elles ont pu nous apporter :</p>
                          <ul>
                              <li><a target="_blank" href="https://openclassrooms.com/fr/courses/4670706-adoptez-une-architecture-mvc-en-php">L\'architecture MVC</a></li>
                              <li><a target="_blank" href="https://sylvie-vauthier.developpez.com/tutoriels/php/grand-debutant/?page=intro-bdd">La base de données et PHP</a></li>
                              <li><a target="_blank" href="https://developer.mozilla.org/fr/docs/Web/CSS">Le CSS</a></li>
                          </ul>
                          <p>En bonus, nous avons voulu ajouter un ballon de football qui suit la souris dans ses déplacements dans le dossier javascript, grâce à <a target="_blank" href="https://github.com/tholman/cursor-effects">ce lien pour la cascade de ballon.</a></p>';
    }

/* Fonction représentant la page pour modifier un club */
    public function ModificationPage(Ligue1Builder $j){
        $tab=$j->getData();
        $this->content="<nav><ul>" ;
        foreach($this->menu as $nom => $url){
            $this->content.='<li class="item"><a href="'.$url.'">'.$nom.'</a></li>';
        }
        $this->content.='</ul>
                        </nav>
                        <form action="'.$this->router->deconnexion().'" method="post">
                        <input id="deco" type="submit" name="logout" value="Déconnexion"/>
                          </form>
                          <br/>
                          <div class="feedback">'.$this->feed.'</div>
                          <br/>
                          <form enctype="multipart/form-data" method="post" action='.$this->router->getEquipeSaveURL().'>
                            <fieldset>
                            <legend>Ajouter un club</legend>
                            <br/>
                              <label>Nom du club :<input type="text" name="titre"  value="'.$this->htmlesc($tab["Titre"]).'"/></label><br/><br/>';


        $this->content.='<label>Date de création du club :<input type="text" name="date"  value="'.$this->htmlesc($tab["Date"]).'"/></label><br><br/>';
        $this->content.="</label><br/>";
        $this->content.='<label>Stade actuel :<input type="text" name="stade"  value="'.$this->htmlesc($tab["Stade"]).'"/></label><br><br/>';
        $this->content.="</label><br/>";
        $this->content.='<label>Entraineur actuel :<input type="text" name="entraineur"  value="'.$this->htmlesc($tab["Entraineur"]).'"/></label><br><br/>';
        $this->content.="</label><br/>";
        $this->content.='<label>Président actuel :<input type="text" name="president"  value="'.$this->htmlesc($tab["President"]).'"/></label><br><br/>';
        $this->content.="</label><br/>";


        $this->content.='<br/>
                                    <label>Ajouter une image :  <input class="ajoutImage" type="file" name="Image" ></label><br/>';
        $this->content.='<br/>
                                  <input class="Boutonajout" type="submit" value="Ajouter équipe" />
                                  </fieldset>
                                  </form><br><br>';
    }


    public static function htmlesc($str) {
        return htmlspecialchars($str,ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,'UTF-8');
    }
}

?>
