<?php
use Dopesong\Slim\Error\Whoops as WhoopsError;

// DIC configuration
$container = $app->getContainer();

// Inject Setting Database satu
$container['dbberrybenka'] = function ($c) {
    $settings = $c->get('settings')['dbberrybenka'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
 
// Inject Setting Database dua
$container['dbwms'] = function ($c) {
    $settings = $c->get('settings')['dbberrybenka_wms'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['redis'] = function ($c) {
    $settings = $c->get('settings')['redis'];
    $connection = new Predis\Client($settings);
    return new Symfony\Component\Cache\Adapter\RedisAdapter($connection);
};

// Infrastructure error handle
$container['errorHandler'] = function ($c) {
    $env = getenv("APP_ENV");
    if ($env != "production") {
        return new WhoopsError($c->get('settings')['displayErrorDetails']);
    } else {
        return function ($request, $response, $exception) use ($c) {
            $data = [
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => explode("\n", $exception->getTraceAsString()),
            ];

            return $c->get('response')->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>500, 'messages'=>'Whoops, looks like something went wrong.']));
        };
    }
};

// Spesific PHP Error Handler
$container['phpErrorHandler'] = function ($c) {
    $env = getenv("APP_ENV");
    if ($env != "production") {
        return new WhoopsError($c->get('settings')['displayErrorDetails']);
    } else {
        return function ($request, $response, $exception) use ($c) {
            $data = [
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => explode("\n", $exception->getTraceAsString()),
            ];

            return $c->get('response')->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>500, 'messages'=>'Whoops, looks like something went wrong.']));
        };
    }
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $_SESSION["last_url"] = $_SERVER["REQUEST_METHOD"] . " - " . $_SERVER["REQUEST_URI"];
        
        return $c->get('response')->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>404, 'messages'=>'Error, Page not found.']));
    };
};

//Override the default Not Found Handler
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $_SESSION["last_url"] = $_SERVER["REQUEST_METHOD"] . " - " . $_SERVER["REQUEST_URI"];

        return $c->get('response')->withStatus(405)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>405, 'messages'=>'Method Not Allowed.']));
    };
};


// Inject Instance directory lib
$container['jwtlib'] = function ($c) {
    return new Lib\JWTLib;
};
