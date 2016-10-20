<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita19ca041ffab0d5140fd44d7e571bdab
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'cURL\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Component\\EventDispatcher\\' => 34,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'cURL\\' => 
        array (
            0 => __DIR__ . '/..' . '/stil/curl-easy/src',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita19ca041ffab0d5140fd44d7e571bdab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita19ca041ffab0d5140fd44d7e571bdab::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
