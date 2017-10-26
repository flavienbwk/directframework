<?php

/*
 * Direct Framework, under MIT license.
 * beta-0.4
 * Automatically includes all classes present in /Model and /Components/modules.
 */

class Autoloader {

    function __construct() {
        spl_autoload_register(array(__CLASS__, "autoload"));
    }

    /**
     * Automatically include any class you want.
     */
    function autoload($class_name) {
        $included = false;

        if (file_exists("../Components/modules")) {
            $directories_modules = $this->getDirectoriesRecursively("../Components/modules");
            $included = $this->requireFile($directories_modules, $class_name);
        }

        if (file_exists("../Model") && !$included) {
            $directories_model = $this->getDirectoriesRecursively("../Model");
            $included = $this->requireFile($directories_model, $class_name);
        }
    }

    function getDirectoriesRecursively($base_dir) {
        $directories = array();

        foreach (scandir($base_dir) as $file) {
            if ($file == '.' || $file == '..')
                continue;
            $dir = $base_dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($dir)) {
                $directories [] = $dir;
                $directories = array_merge($directories, $this->getDirectoriesRecursively($dir));
            }
        }

        return $directories;
    }

    function requireFile($array_paths, $class_name) {
        $included = false;
        $i = 0;

        while (isset($array_paths[$i])) {
            $path_name = $array_paths[$i] . DIRECTORY_SEPARATOR . $class_name . ".php";

            if (file_exists($path_name)) {
                require_once($path_name);
                $included = true;
                break;
            }

            $i++;
        }

        return $included;
    }

}

?>