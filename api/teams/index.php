<?php

/**
 * This is the route for the team api
 * This route handles the REST operations for the team api controller
 */

require_once __DIR__ . "/../../controller/teamApi.php";

use Api\Teams\Teams;

$teams = new Teams();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}


// check if data is an error
if ($teams->data instanceof \Error) {
    http_response_code($teams->data->getCode());
    echo $teams->data->getMessage();
    exit;
}

// check if data is false
if ($teams->data === false) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    exit;
}

// check if data is empty
if (empty($teams->data)) {
    http_response_code(404);
    echo json_encode(["error" => "No teams found"]);
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;

echo json_encode($teams->getPage($page));
