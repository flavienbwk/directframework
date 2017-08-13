<?php

/*
 * Direct Framework, under MIT license.
 * beta-0.1
 * Middleware Router : manage the inclusion and the URI.
 */
session_start();

/*
 * Autoloading the classes.
 */
require("Autoloader.class.php");
Autoloader::register();

/*
 * Extracting config.json parameters.
 */
$no_404_file = json_decode(file_get_contents("config.json"), true);
$no_404 = ($no_404_file["router_url_parameters"] == "true") ? true : false;

if (!empty($_POST)) {
    $_SESSION["directframework"]["post_parameters"] = $_POST;
}

if (isset($_GET["path"])) {
    $path = htmlentities(strtolower($_GET["path"]));
    $path_i = "Controler/" . ucfirst($path) . "/indexControler.php";
    if (file_exists(renderURI($path_i))) {
        require(renderURI($path_i));
    } else {
        header("Location:" . $_SERVER["REQUEST_URI"] . "/");
    }
} else if (isset($_GET["path_dir"]) && isset($_GET["path_file"])) {
    $path_dir = $_GET["path_dir"];
    $path_file = $_GET["path_file"];
    $dirs = explode("/", $path_dir);
    $path_i = "Controler/";
    $path_test = renderURI("Controler/" . ucfirst($dirs[0]) . "/");
    $path_has_parameters_questionmark = (strstr($_SERVER["REQUEST_URI"], "?")) ? true : false;
    if (!$path_has_parameters_questionmark && !empty($path_file) && substr($path_file, -1) != "/") {
        header("Location:" . $_SERVER["REQUEST_URI"] . "/");
    } else {
        if ($path_test) {
            for ($i = 0; $i < sizeof($dirs) - 1; $i++) {
                $path_i .= ucfirst($dirs[$i] . "/");
            }
            $path_s = $path_i . $path_file . "Controler.php";
            $ruri = renderURI($path_s);
            if ($ruri) {
                require($ruri);
            } else {
                $ruri = renderURI($path_i . "indexControler.php");
                if ($ruri) {
                    
                } else {
                    if (empty($path_file) && $no_404) {
                        $path_file = substr($path_dir, 0, -1);
                        $_GET["path_file"] = $path_file;
                        $parameters = explode("/", $path_file);
                        $ruri = renderURI("Controler/Index/indexControler.php");
                        $actual_uri_index_bool = false;
                        for ($i = sizeof($parameters) - 1; $i > 0; $i--) {
                            $actual_path = "";
                            for ($a = 0; $a < $i; $a++) {
                                $actual_path .= ucfirst($parameters[$a]) . "/";
                            }
                            $actual_uri = renderURI("Controler/" . $actual_path . $parameters[$i] . "Controler.php");
                            $actual_uri_index = renderURI("Controler/" . $actual_path . "indexControler.php");
                            if ($actual_uri) {
                                $ruri = $actual_uri;
                                break;
                            } else if ($actual_uri_index) {
                                $actual_uri_index_bool = true;
                                $ruri = $actual_uri_index;
                                break;
                            }
                        }

                        /*
                         * Selecting only the parameters in $_GET["parameters"].
                         */
                        $complement_pi = ($actual_uri_index_bool) ? 0 : 1;
                        $index_parameters_inverse = sizeof($parameters) - (sizeof($parameters) - $i - $complement_pi);
                        if (sizeof($parameters) != 1) {
                            for ($b = 0; $b < $index_parameters_inverse; $b++) {
                                array_shift($parameters);
                            }
                        }
                        $_GET["parameters"] = $parameters;
                        if ($ruri) {
                            
                        } else {
                            header("HTTP/1.0 404 Not Found");
                        }
                    } else {
                        if (substr($_SERVER["REQUEST_URI"], -1) != "/" && $no_404) {
                            header("Location:" . $_SERVER["REQUEST_URI"] . "/");
                        } else {
                            header("HTTP/1.0 404 Not Found");
                        }
                    }
                }
            }
        } else {
            $ruri = $path_test;
            if ($ruri) {
                for ($i = 1; $i < sizeof($dirs); $i++) {
                    $_GET["parameters"][$i - 1] = $dirs[$i];
                }
            } else {
                $ruri = renderURI("Controler/Index/indexControler.php");
                if ($ruri) {
                    for ($i = 0; $i < sizeof($dirs); $i++) {
                        if (!empty($dirs[$i])) {
                            $_GET["parameters"][$i] = $dirs[$i];
                        }
                    }
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
            }
        }
        /*
         * Computing $_GET["path_raw"] (path called).
         */
        $path_raw = "";
        $path_raw_explode = explode("/", $_SERVER["PHP_SELF"]);
        foreach ($path_raw_explode as $pre) {
            if ($pre != "Components") {
                $path_raw .= $pre . "/";
            } else {
                break;
            }
        }
        $_GET["path_raw"] = $path_raw;
        
        require($ruri);
    }
} else {
    header("HTTP/1.0 404 Not Found");
}

function renderURI($path) {
    /*
     * Looks for the right URL depending on
     * the relative path where the file is called.
     */

    $open = $path;
    $open1 = "./" . $path;
    $open2 = "../" . $path;
    $open3 = "./../" . $path;
    $open4 = "../../" . $path;
    if (file_exists($open)) {
        return $path;
    } else if (file_exists($open1)) {
        $path = $open1;
        return $path;
    } else if (file_exists($open2)) {
        $path = $open2;
        return $path;
    } else if (file_exists($open3)) {
        $path = $open3;
        return $path;
    } else if (file_exists($open4)) {
        $path = $open4;
        return $path;
    } else {
        return false;
    }
}
