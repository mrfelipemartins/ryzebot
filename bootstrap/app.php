<?php

require __DIR__.'/../vendor/autoload.php';

$container = new League\Container\Container;

$kernel = FondBot\Application\Factory::create($container);

$container->addServiceProvider(new Bot\Providers\AppServiceProvider);
$container->addServiceProvider(new Bot\Providers\CacheServiceProvider);
$container->addServiceProvider(new Bot\Providers\ChannelServiceProvider);
$container->addServiceProvider(new Bot\Providers\FilesystemServiceProvider);
$container->addServiceProvider(new Bot\Providers\IntentServiceProvider);
$container->addServiceProvider(new Bot\Providers\LogServiceProvider);
$container->addServiceProvider(new Bot\Providers\QueueServiceProvider);

$username = env('DB_USERNAME', 'root');
$password = env('DB_PASSWORD', '');
$db = env('DB_DATABASE', 'ryze');

$pdo = new PDO("mysql:host=localhost;dbname=".$db,$username,$password);
TORM\Connection::setConnection($pdo);
TORM\Connection::setDriver("mysql");