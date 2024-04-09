<?php
    class Historique_film{
        private int $id;
        private int $id_film;
        private DateTime $date; 

        function __construct(int $id, int $id_film, DateTime $date){
            $this->id = $id;
            $this->id_film = $id_film;
            $this->date = $date;
        }
        public function getId(): int{
            return $this->id;
        }
        public function getIdFilm(): int{
            return $this->id_film;
        }
        public function getDate(): DateTime{
            return $this->date;
        }
    }