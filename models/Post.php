<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/php_test_rest/util/cleanAndBind.php";

class Post
{
    private $conn;
    private $table = 'posts';

    public $id;
    public $title;
    public $body;
    public $author;
    public $user_id;
    public $description;

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
                title = :title,
                body = :body,
                user_id = :user_id,
                author = :author,
                description = :description
        ";
        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Clean and bind data
        $stmtWithBindedParams = cleanAndBind(
            [
                'title' => $this->title,
                'body' => $this->body,
                'user_id' => $this->user_id,
                'author' => $this->author,
                'description' => $this->description
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
                title = :title,
                body = :body,
                user_id = :user_id,
                author = :author,
                description = :description
            WHERE 
                id = :id AND user_id = :user_id
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
                'author' => $this->author,
                'description' => $this->description
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

    public function delete()
    {
        //Create query
        $query = "DELETE FROM $this->table WHERE id = :id AND user_id = :user_id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean and Bind data
        $stmtWithBindedParams = cleanAndBind(
            [
                'id' => $this->id,
                'user_id' => $this->user_id
            ],
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
        $query = "SELECT * FROM $this->table ORDER BY published_date DESC";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
}
