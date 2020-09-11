<?php
require_once  $_SERVER['DOCUMENT_ROOT'] . "/php_test_rest/util/cleanAndBind.php";

class User
{
    private $conn;
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;

    //Construst with DB

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        //Create query
        $query = "INSERT INTO $this->table 
            SET 
                name = :name,
                email = :email,
                password = :password
        ";
        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Clean and bind data
        $stmtWithBindedParams = cleanAndBind(
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
            ],
            $stmt
        );

        //Execute query
        if ($stmtWithBindedParams->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmtWithBindedParams->error);

        return false;
    }

    public function emailExists()
    {
        // query to check if email exists
        $query = "SELECT id, name, password
            FROM  $this->table
            WHERE email = ?
            LIMIT 0,1
        ";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->password = $row['password'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }
}
