<?php
	/* Ici, nous avons l'instance d'un utilisateur, composée des attributs nomuser pass et mail. Nous déclarons donc ici ce qu'est un utilisateur afin de pouvoir en implémenter avec les bdd*/	
	class User{
		private $nomuser;
		private $pass;
		private $mail;

		public function __construct($nomuser,$pass,$mail){
			$this->nomuser=$nomuser;
			$this->pass=$pass;
			$this->mail=$mail;
		}

		public function getNomuser(){
			return $this->nomuser;
		}

		public function getPass(){
			return $this->pass;
		}

		public function getMail(){
			return $this->mail;
		}

	}

?>