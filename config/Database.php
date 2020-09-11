<?php
    class Database {
        private $host = 'HOST';
        private $user = 'YOUR_USER';
        private $password = 'YOUR_PASSWORD';
        private $dbname = 'DATABASE_NAME';


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


