<?php
    class Plateforme{
        private int $id;
        private string $plateforme;
        private string $logo;

        //GETTER
        function getId(){
            return $this->id;
        }
        function getPlateforme(){
            return $this->plateforme;
        }
        function getLogo(){
            return $this->logo;
        }

        //CONSTRUCTEUR
        function __construct(int $id, string $plateforme, string $logo){
            $this->id = $id;
            $this->plateforme = $plateforme;
            $this->logo = $logo;
        }
    }