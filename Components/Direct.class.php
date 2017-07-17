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
    var $_session_follow_paths, $_session_notifications;

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

    private function isJson() {
        call_user_func_array('json_decode', func_get_args());
        return (json_last_error() === JSON_ERROR_NONE);
    }

    private function constructGetParameters() {
        /*
         * The router doesn't forward the GET parameters.
         * So we have to build it to find the parameters in the URL.
         */
        $url = $_SERVER["REQUEST_URI"];
        $url = explode("/", $url);
        $url = $url[sizeof($url) - 1];
        $url_get_sentence = explode("?", $url);
        $url_get_sentence = $url_get_sentence[sizeof($url_get_sentence) - 1];
        $url_parameters = explode("&", $url_get_sentence);
        $parameters = array();
        foreach ($url_parameters as $parameter_word) {
            $act_expl_param=explode("=",$parameter_word);
            if(isset($act_expl_param[1])){
                array_push($parameters,array($act_expl_param[0],$act_expl_param[1]));
            }else{
                array_push($parameters,array($act_expl_param[0],""));
            }
        }
        unset($_GET["path"]);
        for($i=0;$i<sizeof($parameters);$i++){
            $parameter_name=$parameters[$i][0];
            $parameter_content=$parameters[$i][1];
            $_GET[$parameter_name]=$parameter_content;
        }
    }

    function __construct() {
        if (file_exists(dirname(__FILE__) . "/config.json")) {
            $config = json_decode(file_get_contents(dirname(__FILE__) . "/config.json"), true);
            if (!empty($config) && json_last_error() == 0) {
                $this->_config = $config;
            } else {
                $this->raiseError("Error accessing config.json.");
            }
        } else {
            $this->raiseError("Inexistant config.json.");
        }
        $this->constructGetParameters();
        $this->_session_follow_paths = &$_SESSION["directframework"]["follow_paths"];
        $this->_session_notifications = &$_SESSION["directframework"]["notifications"];
    }

    public function addError($title, $content = "") {
        if ($this->getConfigVar("active_notifications") == "yes") {
            if (isset($this->_session_notifications["errors"])) {
                array_push($this->_session_notifications["errors"], array("title" => $title, "content" => $content));
            } else {
                $this->_session_notifications["errors"][0]["title"] = $title;
                $this->_session_notifications["errors"][0]["content"] = $content;
            }
        }
    }

    public function addInfo($title, $content = "") {
        if ($this->getConfigVar("active_notifications") == "yes") {
            if (isset($this->_session_notifications["infos"])) {
                array_push($this->_session_notifications["infos"], array("title" => $title, "content" => $content));
            } else {
                $this->_session_notifications["infos"][0]["title"] = $title;
                $this->_session_notifications["infos"][0]["content"] = $content;
            }
        }
    }

    public function showInfos($remove_notifs = true) {

        if (isset($this->_session_notifications["infos"])) {
            foreach ($this->_session_notifications["infos"] as $info) {
                echo $this->raiseInfo($info["title"], $info["content"]);
            }

            if ($remove_notifs) {
                unset($this->_session_notifications["infos"]);
            }
        }
    }

    public function showErrors($remove_notifs = true) {
        if (isset($this->_session_notifications["errors"])) {
            foreach ($this->_session_notifications["errors"] as $error) {
                echo $this->raiseError($error["title"], $error["content"]);
            }

            if ($remove_notifs) {
                unset($this->_session_notifications["errors"]);
            }
        }
    }

    public function showNotifications($remove_notifs = true) {
        /*
         * Shows all notifications.
         */
        $this->showErrors($remove_notifs);
        $this->showInfos($remove_notifs);
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

    public function is_post(array $array) {
        foreach ($array as $arr) {
            if (!isset($_POST[$arr])) {
                return false;
            }
        }
        return true;
    }

    public function is_post_not_empty(array $array) {
        foreach ($array as $arr) {
            if (empty($_POST[$arr])) {
                return false;
            }
        }
        return true;
    }

    public function setFollowPath($path, $overwrite_all_last_path = false) {
        /*
         * Set the path to header.
         * Execute with goFollowPath().
         */

        if ($overwrite_all_last_path || !isset($this->_session_follow_paths)) {
            $this->_session_follow_paths = array($path);
        } else {
            array_push($this->_session_follow_paths, $path);
        }
    }

    public function goFollowPath() {
        /*
         * Header to the set path(s).
         * Path(s) are/is set with setFollowPath().
         */
        if (isset($this->_session_follow_paths) && !empty($this->_session_follow_paths)) {
            $actual_paths = $this->_session_follow_paths;
            array_shift($this->_session_follow_paths); // Removing headered path.
            header("Location:" . $actual_paths[0]);
            exit();
        }
    }

    public function addToLog($content, $title = "", array $options = array()) {
        /*
         * Path of the file in wich is saved the log.
         */
        $filename_log = dirname(__FILE__) . "/Direct.log.json";
        $to_save = array();

        if (!empty($title)) {
            /*
             * If the title is set with a pre_filled key from the array below,
             * it is replaced automatically so you can gain time.
             * 
             * You can add a description to each pre_filled title.
             */
            $pre_filled_array = array(
                "INTERNAL_SCRIPT" => "", // To debug a script.
                "LOGGED_IN" => "User logged in.",
                "LOGGED_OUT" => "User logged out.",
                "ACCESS_DENIED" => ""
            );
            $title = strtr($title, $pre_filled_array);
        }
        $to_save["title"] = $title;

        if (!empty($options)) {
            /*
             * Useful complements added in the end of the sentence.
             * In the $options_str variable.
             */

            $dbt = debug_backtrace();
            $to_save["options"] = array();
            $pre_filled_array = array(
                "backtrace" => $dbt[0]["args"][0], // File from where is called addToLog().
                "user" => (isset($_SESSION["user"]["ids"])) ? $_SESSION["user"]["ids"] : "Unknwown", // User ids or unknown if not logged in.
                "ip" => $this->getIp() // Get user IP.
            );
            foreach ($options as $option) {
                if (isset($pre_filled_array[$option])) {
                    array_push($to_save["options"], array(
                        "f_name" => $option,
                        "content" => (empty($pre_filled_array[$option])) ? "" : $pre_filled_array[$option]
                    ));
                }
            }
        }

        $time = time();
        $to_save["content"] = $content;
        $to_save["date"] = date("H:i d/m/Y", $time);
        $to_save["timestamp"] = $time;

        if (file_exists($filename_log)) {
            $fc = file_get_contents($filename_log);
            if (!empty($fc) && $fc != "null" && $this->isJson($fc)) {
                $fc = json_decode($fc, true);
                array_push($fc, $to_save);
                $to_save = json_encode($fc);
            } else {
                $to_save = json_encode(array(0 => $to_save));
            }
        } else {
            $to_save = json_encode(array(0 => $to_save));
        }
        file_put_contents($filename_log, $to_save);
    }

}
