<?php
/**
 * Simple PSR-0 Autoloader
 *
 * @category  Location
 * @author    Marcus T. Jaschen <mjaschen@gmail.com>
 */
spl_autoload_register(
    function ($class) {
        $file = __DIR__ . '/../src/' . strtr($class, '\\', '/') . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
);
