<?php

/**
 * This is the route for the games api
 * This route handles the REST operations for the games api controller
 */

require_once __DIR__ . "/../../controller/gamesApi.php";

use Api\Games\Games;

$queries_keys = [
    'id',
    'date',
    'live',
    'league',
    'season',
    'team',
    'h2h'
];

$games = new Games();

$emptyQuery = true;

foreach ($queries_keys as $key) {
    if (isset($_GET[$key])) {
        $emptyQuery = false;
        $games->$key = $_GET[$key];
    }
}

if ($emptyQuery) {
    $games->season = date("Y", strtotime("-1 year"));
}

$games->getGames();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}


// check if data is an error
if ($games->data instanceof \Error) {
    http_response_code($games->data->getCode());
    echo $games->data->getMessage();
    exit;
}

// check if data is false
if ($games->data === false) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error"]);
    exit;
}

// check if data is empty
if (empty($games->data)) {
    http_response_code(404);
    echo json_encode(["error" => "No games found"]);
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;

echo json_encode($games->getPage($page));
