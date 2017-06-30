<?php

/*
 * Direct Framework, under MIT license.
 */

if (isset($_GET["path"])) {
    $path = htmlentities(strtolower($_GET["path"]));
    $path_i = "Controler/" . ucfirst($path) . "/indexControler.php";
    require(renderURI($path_i));
} else if (isset($_GET["path_dir"]) && isset($_GET["path_file"])) {
    $path_dir = $_GET["path_dir"];
    $path_file = $_GET["path_file"];
    $dirs = explode("/", $path_dir);
    $path_i = "Controler/";
    for ($i = 0; $i < sizeof($dirs) - 1; $i++) {
        $path_i .= ucfirst($dirs[$i] . "/");
    }
    $path_i .= $path_file . "Controler.php";
    $ruri=renderURI($path_i);
    if ($ruri) {
        require($ruri);
    } else {
        header("HTTP/1.0 404 Not Found");
    }
} else {
    // Error 404.
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