<?php
    class Pays{
        private int $id;
        private string $nom;

        //GETTER
        function getId(){
            return $this->id;
        }
        function getNom(){
            return $this->nom;
        }
        //CONSTRUCTEUR
        function __construct(int $id, String $nom){
            $this->id = $id;
            $this->nom = $nom;
        }
    }