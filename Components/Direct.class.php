<?php

/**
 * General functions of the Direct framework through the
 * always-available Direct class!
 * 
 */
@session_start();
date_default_timezone_set("Europe/Paris");

class Direct {

    private $_config = array();
    var $_session_follow_paths, $_session_notifications, $_session_post;

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

    private function constructPostParameters() {
        /*
         * In some case, when the router performs a redirection,
         * POST variables are not followed.
         * This function allows the POST variable to work flowlessly.
         */

        if (isset($this->_session_post) && !empty($this->_session_post)) {
            $_POST = $this->_session_post;
            unset($_SESSION["directframework"]["post_parameters"]);
        }
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
            $act_expl_param = explode("=", $parameter_word);
            if (isset($act_expl_param[1])) {
                array_push($parameters, array($act_expl_param[0], $act_expl_param[1]));
            } else {
                array_push($parameters, array($act_expl_param[0], ""));
            }
        }
        unset($_GET["path"]);
        for ($i = 0; $i < sizeof($parameters); $i++) {
            $parameter_name = $parameters[$i][0];
            $parameter_content = $parameters[$i][1];
            $_GET[$parameter_name] = $parameter_content;
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
        $this->_session_post = (isset($_SESSION["directframework"]["post_parameters"])) ? $_SESSION["directframework"]["post_parameters"] : null;
        $this->constructPostParameters();
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

    public function renderURI($path, $nav_link = false) {
        if ($nav_link) {
            /*
             * Set it to true when you want to call a link 
             * in your navbar so renderURI() can return
             * a path relative to the name of the controlers.
             */
            return (isset($_GET["path_raw"])) ? $_GET["path_raw"] . $path : "" . $path;
        } else {
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

        if ($this->getConfigVar("log_disable") == "yes") {
            /*
             * Path of the file in wich is saved the log.
             */
            $to_save = array();
            $path = dirname(__FILE__) . "/log/";
            /*
             * Checking log directory presence.
             */
            if (!file_exists($path)) {
                mkdir($path, 0700);
            }
            $log_max_file_size = intval($this->getConfigVar("log_max_file_size"));
            $log_file_number = 0;
            $file_list = array_diff(scandir($path), array('.', '..'));

            if (sizeof($file_list) == 0) {
                $log_file_number = 0;
            } else {
                $log_last_file = $file_list[sizeof($file_list) + 2 - 1];
                $log_last_file_number = explode(".", $log_last_file);
                $log_last_file_number = intval($log_last_file_number[0]);
                if (filesize($path . $log_last_file) >= $log_max_file_size) {
                    $log_file_number = $log_last_file_number + 1;
                } else {
                    $log_file_number = $log_last_file_number;
                }
            }
            $log_filename = $path . $log_file_number . ".log.json";

            if (!empty($title)) {
                /*
                 * If the title is set with a pre_filled key from the array below,
                 * it is replaced automatically so you can gain time.
                 * 
                 * You can add a description to each pre_filled title.
                 * Followings are examples.
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
                 * 
                 * You can insert custom informations using $options["blabla"]=blabla;
                 */

                $dbt = debug_backtrace();
                $to_save["options"] = array();
                $pre_filled_array = array(
                    "backtrace" => $dbt[0]["args"][0], // File from where is called addToLog().
                    "ip" => $this->getIp() // Get user IP.
                );
                foreach ($options as $option=>$val) {
                    if (isset($pre_filled_array[$option])&&is_int($option)) {
                        array_push($to_save["options"], array(
                            "f_name" => $option,
                            "content" => (empty($pre_filled_array[$option])) ? "" : $pre_filled_array[$option]
                        ));
                    }else{
                        array_push($to_save["options"],array(
                           "f_name"=>$option,
                            "content"=>$val
                        ));
                    }
                }
            }

            $time = time();
            $to_save["content"] = $content;
            $to_save["date"] = date("H:i d/m/Y", $time);
            $to_save["timestamp"] = $time;

            if (file_exists($log_filename)) {
                $fc = file_get_contents($log_filename);
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
            file_put_contents($log_filename, $to_save);
        }
    }

}
