<?php
    Class Historique_user{
        private int $id;
        private int $id_user;
        private DateTime $date_heure;
        private int $id_film;
        

        //GETTER
        function getId() {
            return $this->id;
        }
        function getId_user() {
            return $this->id_user;
        }
        function getDateHeure() {
            return $this->date_heure;
        }
        function getId_film() {
            return $this->id_film;
        }       

        //CONSTRUCTEUR
        function __construct($id,$id_user,$date_heure,$is_film) {
            $this->id = $id;
            $this->id_user = $id_user;
            $this->date_heure = $date_heure;
            $this->id_film = $is_film;
        }
    }