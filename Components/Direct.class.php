<?php

/**
 * General functions of the Direct framework through the
 * always-available Direct class!
 * 
 */

session_start();

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

    public function addError($title, $content = ""){
        if(isset($_SESSION["notifications"]["errors"])){
            array_push($_SESSION["notifications"]["errors"],array("title"=>$title,"content"=>$content));
        }else{
            $_SESSION["notifications"]["errors"][0]["title"]=$title;
            $_SESSION["notifications"]["errors"][0]["content"]=$content;
        }
    }
    
    public function addInfo($title, $content = ""){
        if(isset($_SESSION["notifications"]["infos"])){
            array_push($_SESSION["notifications"]["infos"],array("title"=>$title,"content"=>$content));
        }else{
            $_SESSION["notifications"]["infos"][0]["title"]=$title;
            $_SESSION["notifications"]["infos"][0]["content"]=$content;
        }
    }
    
    public function showInfos($remove_notifs = true){
        foreach ($_SESSION["notifications"]["infos"] as $info){
            echo $this->raiseInfo($info["title"],$info["content"]);
        }
        if($remove_notifs){
            unset($_SESSION["notifications"]["infos"]);
        }
    }
    
    public function showErrors($remove_notifs = true){
        foreach ($_SESSION["notifications"]["errors"] as $error){
            echo $this->raiseError($error["title"],$error["content"]);
        }
        if($remove_notifs){
            unset($_SESSION["notifications"]["errors"]);
        }
    }
    
    public function raiseError($title, $content = "") {
        return '<div class="direct-error-frame">'
        . '<span class="error-title">' . $title . '</span>'
        . '<span class="error-content">' . $content . '</span>'
        . '</div>';
    }
    
    public function raiseInfo($title, $content = "") {
        return '<div class="direct-info-frame">'
        . '<span class="info-title">' . $title . '</span>'
        . '<span class="info-content">' . $content . '</span>'
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
