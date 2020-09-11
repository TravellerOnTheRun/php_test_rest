<?php
function setHeaders($method)
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: $method,OPTIONS");
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        header('HTTP/1.1 200 OK');
        die();
    }
}

function initializePostRoute($method, $model)
{
    //Set Headers
    setHeaders($method);

    $modelUpper = strtoupper($model);

    include_once '../../config/Database.php';
    include_once "../../models/$modelUpper.php";

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate new model
    $model = new $modelUpper($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    return [$model, $data];
}

function initializeGetRoute($model)
{
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $modelUpper = strtoupper($model);

    include_once '../../config/Database.php';
    include_once "../../models/$modelUpper.php";

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $model = new $modelUpper($db);

    return $model;
}
