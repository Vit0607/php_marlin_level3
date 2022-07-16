<!doctype html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>

<?php

require '../vendor/autoload.php';

use Aura\SqlQuery\QueryFactory;
use JasonGrimes\Paginator;
use Faker\Factory;
use DI\ContainerBuilder;
use League\Plates\Engine;
use Delight\Auth\Auth;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Engine::class => function () {
        return new Engine('../app/views');
    },

    PDO::class => function () {
        $driver = 'mysql';
        $host = 'localhost';
        $database_name = 'php_marlin_app3';
        $username = 'root';
        $password = '';

        return new PDO("$driver:host=$host;dbname=$database_name", $username, $password);
    },

    Auth::class => function ($container) {
        return new Delight\Auth\Auth($container->get('PDO'));
    }
]);
$container = $containerBuilder->build();

$faker = Factory::create();

//a PDO connection
$pdo = new PDO('mysql:host=localhost;dbname=example01', 'root', '');
$queryFactory = new QueryFactory('mysql');

//$insert = $queryFactory->newInsert();
//
//// insert into this table
//$insert->into('posts');
//for($i = 0; $i < 30; $i++) {
//    $insert->cols([
//          'title' => $faker->words(3, true),
//        'content' => $faker->text
//    ]);
//    $insert->addRow();
//}
//// execute a bulk insert of all rows
//$sth = $pdo->prepare($insert->getStatement());
//$sth->execute($insert->getBindValues());

$select = $queryFactory->newSelect();
$select
    ->cols(['*'])
    ->from('posts');

// prepare the statement
$sth = $pdo->prepare($select->getStatement());

// bind the values and execute
$sth->execute($select->getBindValues());
$totalItems = $sth->fetchAll(PDO::FETCH_ASSOC);

$select = $queryFactory->newSelect();
$select
    ->cols(['*'])
    ->from('posts')
    ->setPaging(3)
    ->page($_GET['page'] ?? 1);

// prepare the statement
$sth = $pdo->prepare($select->getStatement());

// bind the values and execute
$sth->execute($select->getBindValues());

//get the results back as an associative array
$items = $sth->fetchAll(PDO::FETCH_ASSOC);

$itemsPerPage = 3;
$currentPage = $_GET['page'] ?? 1;
$urlPattern = '?page=(:num)';

$paginator = new Paginator(count($totalItems), $itemsPerPage, $currentPage, $urlPattern);

foreach ($items as $item) {
    echo $item['id'] . PHP_EOL . $item['title'] . '<br>';
}
?>

<?= $paginator; ?>


echo 123;


</body>
</html>

<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/home', ['App\controllers\HomeController', 'index']);
    $r->addRoute('GET', '/about', ['App\controllers\HomeController', 'about']);
    $r->addRoute('GET', '/verification', ['App\controllers\HomeController', 'email_verification']);
    $r->addRoute('GET', '/login', ['App\controllers\HomeController', 'login']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($routeInfo[1], $routeInfo[2]);
        // ... call $handler with $vars
        break;
}




