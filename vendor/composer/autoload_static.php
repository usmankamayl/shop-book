<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb76cf9f8e0d2b724e99342abb1a159a9
{
    public static $prefixesPsr0 = array (
        'a' => 
        array (
            'app\\' => 
            array (
                0 => __DIR__ . '/../..' . '/',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitb76cf9f8e0d2b724e99342abb1a159a9::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitb76cf9f8e0d2b724e99342abb1a159a9::$classMap;

        }, null, ClassLoader::class);
    }
}