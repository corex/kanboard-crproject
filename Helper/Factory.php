<?php

namespace Kanboard\Plugin\CRProject\Helper;

use Kanboard\Core\Http\Request;
use Kanboard\Model\ColorModel;
use Pimple\Container;

class Factory
{
    /**
     * @var Container
     */
    private static $container;

    private static $instances;

    /**
     * Color model.
     *
     * @return ColorModel|object
     * @throws \Exception
     */
    public static function colorModel()
    {
        return self::instance(ColorModel::class);
    }

    /**
     * Request.
     *
     * @return Request
     * @throws \Exception
     */
    public static function request()
    {
        $container = self::container();
        return $container['request'];
    }

    /**
     * Color helper.
     *
     * @return ColorHelper|object
     * @throws \Exception
     */
    public static function colorHelper()
    {
        return self::instance(ColorHelper::class);
    }

    /**
     * Widget helper.
     *
     * @return WidgetHelper|object
     * @throws \Exception
     */
    public static function widgetHelper()
    {
        return self::instance(WidgetHelper::class);
    }

    /**
     * Set container.
     *
     * @param Container $container
     */
    public static function setContainer(Container $container)
    {
        self::$container = $container;
    }

    /**
     * Instance.
     *
     * @param string $class
     * @return object
     * @throws \Exception
     */
    private static function instance($class)
    {
        $container = self::container();
        if (!is_array(self::$instances)) {
            self::$instances = [];
        }
        if (!array_key_exists($class, self::$instances) || !is_object(self::$instances[$class])) {
            self::$instances[$class] = new $class($container);
        }
        return self::$instances[$class];
    }

    /**
     * Container.
     *
     * @return Container
     * @throws \Exception
     */
    private static function container()
    {
        if (self::$container === null) {
            throw new \Exception('Container not set.');
        }
        return self::$container;
    }
}