<?php


     class Conexao{

        public $conn;

        public function __construct()
        {
            try{
                $this->conn = new PDO('mysql:host=localhost;dbname=crud', 'root', '');

            }catch(PDOException $e){
                echo "Erro ao conectar no banco: ".$e->getMessage();
            }
        }
    }
?>
