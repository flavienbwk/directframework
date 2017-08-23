<?php

/*
 * Direct Framework, under MIT license.
 * beta-0.3
 * Automaticaly instanciate the Page class and other libraries if requested. 
 */

class Autoloader {

    static function register() {
        spl_autoload_register(array(__CLASS__, "autoload"));
    }

    /**
     * Automatically include any class you want.
     */
    static function autoload($class_name) {
        require("Page.class.php");
    }

}
