<?php

include("Direct.class.php");

/**
 * Description of the Page class.
 * This class manage the important functions of the framework
 * related to the 
 * 
 */
class Page extends Direct {

    private $_page_title, $_language;

    public function __construct() {
        parent::__construct();
        $this->_page_title = $this->getConfigVar("project_title");
        $this->setTitle($this->getConfigVar("project_title"));
        $this->setLanguage("en");
        
        $this->goFollowPath(); // Facultative.
    }

    public function setLanguage($language) {
        if (file_exists(dirname(__FILE__) . "/langs/" . $language . "/")) {
            $this->_language = $language;
        } else {
            $this->raiseError("Inexistant language. Not found under langs/<b>$language</b>. Replaced with english (en).");
        }
    }

    public function getString($var, $file = false, $language = false) {
        /*
         * Get the text from the strings stored in Components/langs/*.
         * '*' represents the name of the file (here, the $file value).
         * 
         * If $file is not filled when calling the function,
         * the function is automatically looking a json file in
         * Components/langs/* in which "*" takes the value
         * of the name of the folder from which is called the view
         * and the name of the view file (without the View suffix).
         * Form : FolderFilename.json
         * Example : IndexIndex.json
         */

        if ($language && !empty($language)) {
            $this->setLanguage($language);
        }

        if ($file === false) {
            $backtrace = debug_backtrace();
            $backtrace = explode("/", $backtrace[0]["file"]);
            $backtrace_file = $backtrace[sizeof($backtrace) - 1];
            if (substr($backtrace_file, -8) == "View.php") {
                $backtrace_file = substr($backtrace_file, 0, -8);
            } else if (substr($backtrace_file, -13) == "Controler.php") {
                $backtrace_file = substr($backtrace_file, 0, -13);
            } else if (substr($backtrace_file, -9) == "Model.php") {
                $backtrace_file = substr($backtrace_file, 0, -9);
            } else {
                $this->raiseError("Impossible to get the backtrace. (" . $var . ", for " . $backtrace_file . ", " . substr($backtrace_file, -8) . ")");
                exit();
            }
            $backtrace_folder = $backtrace[sizeof($backtrace) - 2];
            $file = $backtrace_folder . "." . $backtrace_file . ".json";
        }

        $path = dirname(__FILE__) . "/langs/" . $this->_language . "/" . $file;
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (isset($data[$var])) {
                return $data[$var];
            } else {
                return false;
            }
        } else {
            $this->raiseError("Inexistant traduction file (" . $this->_language . "/" . $file . ").");
            exit();
        }
    }

    public function setTitle($title, $overwrite = false) {
        /*
         * If $overwrite is set true, it won't overwrite the actual 
         * title and will add $title to the actual title set.
         */

        if (!empty($title)) {
            if ($overwrite) {
                $this->_page_title .= $title;
            } else {
                $this->_page_title = $title;
            }
        }
    }

    public function includeFile($file_name) {
        require($this->renderURI($file_name));
    }

    public function getTitle() {
        return $this->_page_title;
    }

    public function getLanguage() {
        return $this->_language;
    }

}