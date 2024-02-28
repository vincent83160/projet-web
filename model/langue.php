<?php
    class Langue{
        private int $id;
        private string $langue;

        function __construct(int $id, string $langue){
            $this->id = $id;
            $this->langue = $langue;
        }
        function getId(): int{
            return $this->id;
        }
        function getLangue(): string{
            return $this->langue;
        }
    }