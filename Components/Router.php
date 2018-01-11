
<?php

/*
 * Direct Framework, under MIT license.
 * beta-0.5
 * Middleware Router : manage the inclusion and the URI.
 */
session_start();

/*
 * Autoloading the classes.
 */
require("Autoloader.class.php");
require("Page.class.php");
$Autoloader = new Autoloader;
$index_filename = "indexController.php";

/*
 * Extracting config.json parameters.
 */
if (!empty($_POST)) {
    $_SESSION["directframework"]["post_parameters"] = $_POST;
}

if (isset($_GET["index"]) || (!isset($_GET["index"]) && 
empty($_GET["index"]))) {
    if (@file_exists("../Controller/Index/$index_filename")) {
        require("../Controller/Index/$index_filename");
    }
} else if (isset($_GET["url"])) {
    $path = htmlentities(strtolower($_GET["url"]));
    $split_url = explode("/", $path);
    $found = false;
    $path_i = "";
    $stack_ucfirst = "../Controller";
    $split_url = array_values(array_filter($split_url));

    for ($i = 0; $i < sizeof($split_url); $i++) {
        $current_url = $split_url[$i];
        $next_url = (isset($split_url[$i + 1])) ? $split_url[$i + 1] : false;
        $stack_ucfirst .= "/" . ucfirst($current_url);
        $path_test_index = $stack_ucfirst . "/$index_filename";

        if (is_dir($stack_ucfirst)) {
            if (isset($split_url[$i + 1]) && !is_dir($stack_ucfirst . "/" . ucfirst($split_url[$i + 1]))) {
                if (file_exists($stack_ucfirst . "/" . $split_url[$i + 1] . "Controller.php")) {
                    $found = true;
                    $last_valid_uri = $stack_ucfirst . "/" . $split_url[$i + 1] . "Controller.php";
                    $i++;
                } else if (file_exists($stack_ucfirst . "/" . $index_filename)) {
                    $found = true;
                    $last_valid_uri = $stack_ucfirst . "/" . $index_filename;
                }
            }
        }

        if ($found) {
            /*
             * Computing $_GET["parameters"];
             */
            $i++;
            while ($i < sizeof($split_url)) {
                $_GET["parameters"][] = $split_url[$i];
                $i++;
            }
            break;
        } else {
            if (isset($split_url[$i + 1]) && file_exists($stack_ucfirst . "/" . ucfirst($split_url[$i + 1]) . "/" . $index_filename)) {
                $found = true;
                $last_valid_uri = $stack_ucfirst . "/" . ucfirst($split_url[$i + 1]) . "/" . $index_filename;
            } else if (file_exists($stack_ucfirst . "/indexController.php")) {
                $found = true;
                $last_valid_uri = $stack_ucfirst . "/indexController.php";
            }
        }
    }
    
    if ($found) {
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
        
        require(renderURI($last_valid_uri));
    } else {
        header("HTTP/1.0 404 Not Found");
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
    if (@file_exists($open)) {
        return $path;
    } else if (@file_exists($open1)) {
        $path = $open1;
        return $path;
    } else if (@file_exists($open2)) {
        $path = $open2;
        return $path;
    } else if (@file_exists($open3)) {
        $path = $open3;
        return $path;
    } else if (@file_exists($open4)) {
        $path = $open4;
        return $path;
    } else {
        return false;
    }
}
