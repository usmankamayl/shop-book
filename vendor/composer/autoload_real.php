<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb76cf9f8e0d2b724e99342abb1a159a9
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitb76cf9f8e0d2b724e99342abb1a159a9', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb76cf9f8e0d2b724e99342abb1a159a9', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb76cf9f8e0d2b724e99342abb1a159a9::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}