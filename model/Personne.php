<?php
    class Personne{
        private int $id;
        private string $name;
        private string $prenom;
        private string $image;

        function __construct(int $id, string $name, string $prenom, string $image){
            $this->id = $id;
            $this->name = $name;
            $this->prenom = $prenom;
            $this->image = $image;
        }
        public function getId(): int{ 
            return $this->id;
        }
        public function getName(): string{
            return $this->name;
        }
        public function getPrenom(): string{
            return $this->prenom;
        }
        public function getImage(): string{
            return $this->image;
        }
    }