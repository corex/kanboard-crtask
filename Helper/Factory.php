<?php

namespace Kanboard\Plugin\CRTask\Helper;

use Kanboard\Core\Helper;
use Kanboard\Helper\UrlHelper;
use Kanboard\Model\ColorModel;
use Pimple\Container;

class Factory
{
    /**
     * @var Container
     */
    private static $container;

    /**
     * @var array
     */
    private static $instances;

    /**
     * Url helper.
     *
     * @return UrlHelper
     * @throws \Exception
     */
    public static function urlHelper()
    {
        $containerHelper = self::containerHelper();
        return $containerHelper->url;
    }

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
     * @return Request|object
     * @throws \Exception
     */
    public static function request()
    {
        return self::instance(Request::class);
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
     * Container helper.
     *
     * @return Helper
     * @throws \Exception
     */
    private static function containerHelper()
    {
        $container = self::container();
        return $container['helper'];
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