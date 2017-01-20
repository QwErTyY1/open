<?php

require_once __DIR__.'/autoloadPhp.php';


if (isset($_GET['ctrl'])) {
    $ctrl = $_GET['ctrl'];
} else {
    $ctrl = 'News';
}

if (isset($_GET['act'])) {
    $act = $_GET['act'];
} else {
    $act = 'All';
}


$controllerClassName = $ctrl.'Controller';

require  __DIR__. '/controllers/'.$controllerClassName.'.php';

$controller = new $controllerClassName();
$method = 'action'.$act;

try{
    $controller->$method();
}catch (ModelException $e){
    $view = new View();
    $view->error = $e->getMessage();
    $view->display('error.php');


}


