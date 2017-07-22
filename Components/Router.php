<?php

/*
 * Direct Framework, under MIT license.
 * ed-0.4
 */

$no_404_file = json_decode(file_get_contents("config.json"), true);
$no_404 = ($no_404_file["router_url_parameters"] == "true") ? true : false;

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
            require($ruri);
        } else {
            if (empty($path_file) && $no_404) {
                $path_file = substr($path_dir, 0, -1);
                $_GET["path_file"] = $path_file;
                $ruri = renderURI("Controler/Index/indexControler.php");
                if ($ruri) {
                    require($ruri);
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
