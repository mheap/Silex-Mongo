<?php


namespace SilexMongo;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Doctrine\MongoDB\Connection,
    Doctrine\MongoDB\Configuration,
    Doctrine\Common\EventManager;

class MongoDbExtension implements ServiceProviderInterface
{
    public function boot(Application $app)
    {

    }

    public function register(Application $app)
    {
        /**
         * Default options
         */
        $options = array(
            'server'  => null,
            'options' => array(
                'connect'   => false
            )
        );

        $app['mongodb'] = $app->share(function () use ($app, $options) {

            $configuration = new Configuration();
            $eventmanager  = new EventManager();

            $connOpts = isset($app['mongodb.connection']) ?
                array_merge($options, $app['mongodb.connection']): $options;

            if(isset($connOpts['configuration']) && is_callable($connOpts['configuration'])) {
                call_user_func_array($connOpts['configuration'], array($configuration));
            }
            if(isset($connOpts['eventmanager']) && is_callable($connOpts['eventmanager'])) {
                call_user_func_array($connOpts['eventmanager'], array($eventmanager));
            }

            return new Connection($connOpts['server'], $connOpts['options'], $configuration, $eventmanager);
        });

        $app['mongodb.configuration'] = $app->share(function () use ($app) {
            return $app['mongodb']->getConfiguration();
        });

        $app['mongodb.eventmanager'] = $app->share(function () use ($app) {
            return $app['mongodb']->getEventManager();
        });
    }
}
