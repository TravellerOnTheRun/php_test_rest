<?php
    class Database {
        private $host = 'localhost';
        private $user = 'root';
        private $password = 'aleksivchenko1344';
        private $dbname = 'php_job_test';


        public function connect() {
            $this->conn = null;

            try {
                $dsn = "mysql:host=$this->host;dbname=$this->dbname";
                $this->conn = new PDO($dsn, $this->user, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $err) {
                echo 'Connection error: ' . $err->getMessage();
            }

            return $this->conn;
        }
        
    }


