<?php
    /* Cette instance est représentée par un nom de club une date de création le stade, l'entraineur et le président actuels
    Bien entendu les accesseurs sont associés à la fonction de construction*/
    class Ligue1{
        private $nom;
        private $date;
        private $stade;
        private $entraineur;
        private $president;
        
        
        public function __construct($nom,$date,$stade,$entraineur, $president){
            $this->nom=$nom;
            $this->date=$date;
            $this->stade=$stade;
            $this->entraineur=$entraineur;
            $this->president=$president;
        }
        
        
        /**
         * @return mixed
         */
        public function getNom()
        {
            return $this->nom;
        }
    
        /**
         * @return mixed
         */
        public function getDate()
        {
            return $this->date;
        }
    
        /**
         * @return mixed
         */
        public function getStade()
        {
            return $this->stade;
        }
    
        /**
         * @return mixed
         */
        public function getEntraineur()
        {
            return $this->entraineur;
        }
    
        /**
         * @return mixed
         */
        public function getPresident()
        {
            return $this->president;
        }
    
     
   
    }

 ?>
