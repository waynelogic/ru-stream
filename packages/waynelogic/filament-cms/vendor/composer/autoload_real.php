<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit01c499e156d7b9f07b0d4e21a5e5824c
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

        spl_autoload_register(array('ComposerAutoloaderInit01c499e156d7b9f07b0d4e21a5e5824c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit01c499e156d7b9f07b0d4e21a5e5824c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit01c499e156d7b9f07b0d4e21a5e5824c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
