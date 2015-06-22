<?php
include_once 'Router.php';
include_once 'Response.php';
include_once 'Query.php';
include_once 'DB.php';

header('Content-type: text/html');
header("Access-Control-Allow-Origin: *");

$x1 = Router::get('x1', 14.0613725);
$y1 = Router::get('y1', 50.0088488);
$x2 = Router::get('x2', 14.5613725);
$y2 = Router::get('y2', 50.1088488);
$limit = Router::get('limit', 500);

if ($limit > 10000) {
    echo Response::asJson([
        "message" => "Limit can not be bigger than 10000"
    ]);
    exit();
}

if (! $x1 || ! $y1 || ! $x2 || ! $y2) {
    echo Response::asJson([
        "message" => "Misssing x1, y1, x2, y2 coordinates"
    ]);
    exit();
}

if (! file_exists("config/db.ini")) {
    echo Response::asJson([
        "message" => "Rename file config/db.ini.dist to config/db.ini and set connection parameters for database"
    ]);
    exit();
}

$dbConfig = parse_ini_file("config/db.ini");
$db = new DB($dbConfig['servername'], $dbConfig['database'], $dbConfig['username'], $dbConfig['password']);
$q = new Query($db->getConnection());
$response['records'] = $q->find($x1, $y1, $x2, $y2, $limit);
$db->close();

echo Response::asJson($response);

?>