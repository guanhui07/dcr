<?php
declare(strict_types = 1);

namespace dcr;

use DI\ContainerBuilder;
use Exception;

/**
 * 服务容器 Di
 * Class Container
 * @see  https://github1s.com/PHP-DI/demo/blob/HEAD/app/bootstrap.php
 */
class Container
{
    /**
     * @var \DI\Container
     */
    public static $ins;

    /**
     * @return \DI\Container
     * @throws Exception
     */
    public static function instance(): \DI\Container
    {
        if ( !self::$ins) {
            $containerBuilder = new ContainerBuilder;
            //            $configs = require('../config/app.php');
            //            $containerBuilder->addDefinitions(__DIR__ . '/config.php');
            //            $containerBuilder->addDefinitions($configs['aliases']);
            //            $containerBuilder->addDefinitions([]);
            $containerBuilder->addDefinitions([
                //                'route' => \DI\create(Route::class)
            ]);
            $container = $containerBuilder->build();
            //            foreach ($configs as $k=>$config) {
            //
            //                $container->make($config,[]);
            //            }
            self::$ins = $container;
            return $container;
        }

        return self::$ins;
    }
}