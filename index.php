<?php
require_once 'db.php';
require_once 'controllers/controller.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// You should always display errors since this is for development
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$ctrlName = $_GET['ctrl'];
$ctrl = Controller::create($ctrlName);
$output = array();

switch (strtolower($_SERVER['REQUEST_METHOD'])) {
    case 'get':
        $output = $ctrl->get();
        break;
    case 'post':
        $output = $ctrl->post();
        break;
    case 'put':
        $output = $ctrl->update();
        break;
    case 'delete':
        $output = $ctrl->delete();
        break;
}

// Headers, change as needed...
header('Content-Type: application/json; charset: UTF-8');
header('Access-Control-Allow-Origin: *');
echo json_encode($output);
