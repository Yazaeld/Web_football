<?php
	/* Inclusion des fichiers utilisés */
	require_once ('model/Ligue1Storage.php');

	/* Ici, on implémente notre interface via des requetes SQL qui permettent l'interactions avec les bdd. Ainsi grâce aux attributs(nom, nomuser, etc.. on peut donc créer de nouvelles lignes dans la bdd et récuperer des lignes existantes*/

	class Ligue1StorageMySQL  implements Ligue1Storage {
	  public $bd;

	  	public function __construct(PDO $BD){
	  		$this->bd=$BD;
			$this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	}

	  	public function createUser(User $u){
			$rq ="INSERT INTO User VALUES(:nomuser,:pass,:mail)";
			$stmt = $this->bd->prepare($rq);
			$pass=$u->getPass();
			$hash=password_hash($pass, PASSWORD_BCRYPT);
			$data = array(":nomuser" =>$u->getNomuser(),":pass" =>$hash,":mail" =>$u->getMail());
			$stmt->execute($data);
		}


		public function AllUsers(){
			$rq=$this->bd->query("SELECT * FROM User");
			$res=$rq->fetchAll();
			return $res;
		}


		public function createEquipe(Ligue1 $j){
			$rq="INSERT INTO Equipes VALUES (:nom,:date,:stade,:entraineur,:president)";
			$tmp= $this->bd->prepare($rq);
			$data = array(":nom" =>$j->getNom(),":stade" =>$j->getStade(),":entraineur" =>$j->getEntraineur(),":president" =>$j->getPresident(), ":date"=>trim($j->getDate()));
			$tmp->execute($data);
		}

		public function AllEquipeByUser($nomuser){
			$rq="SELECT * FROM Equipes WHERE nom IN (SELECT nom FROM UserEquipe where nomuser like :nomuser)";
			$tmp= $this->bd->prepare($rq);
			$data = array(":nomuser" =>$nomuser);
			$tmp->execute($data);
			$res=$tmp->fetchAll();
			return $res;
		}
		public function AllEquipe(){
			$rq=$this->bd->query("SELECT * FROM Equipes");
			$res=$rq->fetchAll();
			return $res;
		}

		public function getImageByEquipe($nom){
			$rq="SELECT image FROM LogoEquipeUser WHERE nom like :nom";
			$tmp= $this->bd->prepare($rq);
			$data = array(":nom" =>$nom);
			$tmp->execute($data);
			$res=$tmp->fetch();
			return $res;

		}

		public function AjoutImage($nom,$nomuser,$img){
			$rq="INSERT INTO LogoEquipeUser VALUES (:nomuser,:nom,:image)";
			$tmp= $this->bd->prepare($rq);
			$data = array(":nom" =>$nom,":nomuser" =>$nomuser,":image" =>$img);
			$tmp->execute($data);
		}

		public function AjoutEquipeUser($nom,$nomuser){
			$rq="INSERT INTO UserEquipe VALUES (:nomuser,:nom)";
			$tmp= $this->bd->prepare($rq);
			$data = array(":nom" =>$nom,":nomuser" =>$nomuser);
			$tmp->execute($data);

		}

		public function EquipeByNom($nom){
			$rq="SELECT * FROM Equipes WHERE Nom like :nom";
			$tmp= $this->bd->prepare($rq);
			$data = array(":nom" =>$nom);
			$tmp->execute($data);
			$res=$tmp->fetch();
			return $res;
		}

      	public function AllImageUser($nomuser){
			$rq=$this->bd->prepare("SELECT image FROM LogoEquipeUser WHERE nomuser like :nomuser");
			$data = array(":nomuser" =>$nomuser);
			$rq->execute($data);
			$result = $rq->fetchAll();
			return $result;
		}

      	public function delete($nom){
      		$rq=$this->bd->prepare("DELETE FROM Equipes WHERE Nom like :nom");
      		$rq2=$this->bd->prepare("DELETE FROM UserEquipe WHERE Nom like :nom");
      		$rq3=$this->bd->prepare("DELETE FROM LogoEquipeUser WHERE Nom like :nom");
			$data = array(":nom" =>$nom);
			$rq->execute($data);
			$rq2->execute($data);
			$rq3->execute($data);
      	}

      	public function Modification(Ligue1 $j,$nom){
      		$this->delete($nom);
      		$this->createEquipe($j);
      	}
	}
 ?>
