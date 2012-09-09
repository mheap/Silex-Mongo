<?php

require_once __DIR__ . '/../vendor/autoload.php';

class MyListener {
    function postConnect() { 
        print_r(func_get_args()); 
    }
}

$app = new Silex\Application();

$app->register(new SilexMongo\MongoDbExtension(), array(
    'mongodb.connection'    => array(
        'configuration' => function($configuration) {
            $configuration->setLoggerCallable(function($logs) {
                print_r($logs);
            });    
        },
        'eventmanager' => function($eventmanager) {
            $eventmanager->addEventListener('postConnect', new MyListener());
        }
    )
));

$app->get('/', function() use($app) {
    $dbs = $app['mongodb']->listDatabases();
    return 'You have ' . count($dbs) . ' Databases';
});

$app->run();