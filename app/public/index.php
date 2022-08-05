<?php

use App\Container;
use App\Exceptions\ValidationException;
use App\MainController;

require __DIR__ . '/../vendor/autoload.php';
const APP_DIR = __DIR__ . '/../src/';

$app = Container::app();

try {
    session_start();
    /** @var MainController $controller */
    $controller = $app->get(MainController::class);
    $phpVariables = $controller->handle();
    extract ($phpVariables);
} catch (ValidationException $exception) {
    $_SESSION['error'] = 'Error: ' . $exception->getMessage();
} catch (\Throwable $exception) {
    var_dump($exception->getMessage());
    $_SESSION['error'] = 'Error: Sorry, something went wrong.';
}

include(APP_DIR . 'html/main.php');
