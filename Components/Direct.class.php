<?php

/**
 * General functions of the Direct framework through the
 * always-available Direct class!
 * 
 */

session_start();
date_default_timezone_set("Europe/Paris");

class Direct {

    private $_config = array();

    public function directVersion() {
        return $this->_config["direct_version"];
    }

    public function appVersion() {
        return $this->_config["app_version"];
    }

    public function getConfigVar($varname) {
        if (isset($this->_config[$varname])) {
            return $this->_config[$varname];
        } else {
            return false;
        }
    }

    function __construct() {
        if (file_exists(dirname(__FILE__)."/config.json")) {
            $config = json_decode(file_get_contents(dirname(__FILE__)."/config.json"), true);
            if (!empty($config) && json_last_error() == 0) {
                $this->_config = $config;
            } else {
                $this->raiseError("Error accessing config.json.");
            }
        } else {
            $this->raiseError("Inexistant config.json.");
        }
    }

    public function raiseError($title, $content = "") {
        echo '<div class="direct-error-frame">'
        . '<span class="error-title">' . $title . '</span>'
        . '<span class="error-content">' . $content . '</span>'
        . '</div>';
    }

    public function getIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($ip == "::1") {
            $ip = "212.27.63.138"; //Default IP (Paris)
        }
        return $ip;
    }

    public function renderURI($path) {
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

}
