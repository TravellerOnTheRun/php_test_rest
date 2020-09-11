<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/php_test_rest/util/cleanAndBind.php";

class Comment
{
    private $conn;
    private $table = 'comments';

    public $id;
    public $body;
    public $user_id;
    public $post_id;
    public $username;

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
                    body = :body,
                    user_id = :user_id,
                    post_id = :post_id,
                    username = :username
            ";
        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Clean and bind data
        $stmtWithBindedParams = cleanAndBind(
            [
                'body' => $this->body,
                'user_id' => $this->user_id,
                'post_id' => $this->post_id,
                'username' => $this->username
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


    public function update()
    {
        //Create query
        $query = "UPDATE $this->table 
            SET 
                body = :body,
                user_id = :user_id,
                post_id = :post_id
            WHERE 
                id = :id
        ";
        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Clean and bind data
        $stmtWithBindedParams = cleanAndBind(
            [
                'id' => $this->id,
                'title' => $this->title,
                'body' => $this->body,
                'user_id' => $this->user_id,
                'author' => $this->author
            ],
            $stmt
        );

        print_r($stmtWithBindedParams);

        //Execute query
        if ($stmtWithBindedParams->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmtWithBindedParams->error);

        return false;
    }

    public function delete()
    {
        //Create query
        $query = "DELETE FROM $this->table WHERE id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean and Bind data
        $stmtWithBindedParams = cleanAndBind(
            ['id' => $this->id],
            $stmt
        );
        //Execute query
        if ($stmtWithBindedParams->execute()) {
            return true;
        }

        //Print error
        printf("Error: %s.\n", $stmtWithBindedParams->error);

        return false;
    }

    public function read()
    {
        $query = "SELECT * FROM $this->table  
            WHERE 
                post_id = :post_id
            ORDER BY 
                publish_date DESC
        ";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        $this->post_id = htmlspecialchars(strip_tags($this->post_id));
        $stmt->bindParam(":post_id", $this->post_id);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
}
