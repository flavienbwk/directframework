<?php

class uploadSingle {
    /*
     * This class allows you to easily upload
     * one document.
     */

    private $_files_data = null;
    private $_last_error_code = null;
    private $_file_name, $_file_destination, $_file_extension, $_file_path;
    private $_valid_upload = false;
    private $_file_max_size = 0; // Unlimited by default.
    private $error_codes_list = array(
        0 => "Fichier correctement uploadé.",
        1 => "Nom de fichier incorrect.",
        2 => "Longueur du nom du fichier incorrect.",
        3 => "Extension non autorisée.",
        4 => "Taille du fichier maximal excédé.",
        5 => "Erreur lors de l'importation du fichier.",
        6 => "Destination du fichier introuvable"
    );
    private $authorized_extensions = null;

    /**
     * uploadSingle
     *
     * Allows you to instantly and easily upload one document.
     *
     * @param array $_FILES The $_FILES variable itself
     * @param string $file_name Final name of the uploaded file (without the extension)
     * @param string $file_destination The directory of destination
     * @param string $file_extension If not specified, use the actual file extension automatically
     * @author Flavien Berwick
     */
    public function __construct(array $file, string $file_name, string $file_destination, string $file_extension = null) {
        $this->_files_data = $file;
        $this->_file_destination = $file_destination;
        $this->_file_name = $file_name;
        if (!isset($file_extension)||empty($file_extension)) {
            $fe_e = explode(".", $file["name"]);
            $this->_file_extension = $fe_e[sizeof($fe_e) - 1];
        } else {
            $this->_file_extension = "";
        }
        $this->_file_path = $file_destination . "/" . $file_name . "." . $this->_file_extension;
    }

    /**
     * upload
     *
     * Execute the upload.
     * Returns true or false depending on the success of the request.
     */
    public function upload() {
        $return = false;
        if (file_exists($this->_file_destination)) {
            if ($this->check_file_uploaded_length($this->_file_name)) {
                if ($this->check_file_uploaded_name($this->_file_name)) {
                    if ($this->_file_max_size == 0 || intval($this->_files_data["size"]) <= $this->_file_max_size) {
                        if ($this->check_extension_file()) {
                            if (move_uploaded_file($this->_files_data["tmp_name"], $this->_file_path)) {
                                $return = true;
                                $this->_last_error_code = 0;
                            } else {
                                $this->_last_error_code = 5;
                            }
                        } else {
                            $this->_last_error_code = 3;
                        }
                    } else {
                        $this->_last_error_code = 4;
                    }
                } else {
                    $this->_last_error_code = 1;
                }
            } else {
                $this->_last_error_code = 2;
            }
        } else {
            $this->_last_error_code = 6;
        }
        return $return;
    }

    /**
     * 
     * Return the extension of the file given.
     * 
     * @return string
     */
    public function getFileExtension() {
        return $this->_file_extension;
    }

    /**
     * setMaxFileSize
     *
     * Allows you precise a max file size. If the file size exceeds the size specified, the upload will fail and throw an error 3.
     * 
     */
    public function setMaxFileSize(int $value) {
        if (is_int($value)) {
            $this->_file_max_size = $value;
        } else {
            return false;
        }
    }

    /**
     * isLastUploadValid
     *
     * Allows you know if the last upload was a success or not.
     */
    public function isLastUploadValid() {
        return (bool) $this->_valid_upload;
    }

    /**
     * getLastError
     *
     * Allows you to retrieve the last error.
     */
    public function getLastError() {
        return (isset($this->error_codes_list[$this->_last_error_code])) ? $this->error_codes_list[$this->_last_error_code] : "Generic error.";
    }

    /**
     * getLastErrorCode
     *
     * Allows you to retrieve the last error.
     * 1 = invalid file name.
     * 2 = invalid size file name.
     * 3 = invalid extension (refused).
     * 4 = max file size exceeded.
     * 5 = move uploaded file error.
     */
    public function getLastErrorCode() {
        return $this->_last_error_code;
    }

    /**
     * removeLastFile
     *
     * Allows you to easily remove the last file uploaded.
     */
    public function removeLastFile() {
        if (file_exists($this->_file_path)) {
            unset($this->_file_path);
            return true;
        } else {
            return false;
        }
    }

    /**
     * setAuthorizedExtensions
     *
     * Allows you to specify authorized extensions.
     * 
     * @param array $extensions Tableau d'extensions autorisées (sans le point)
     */
    public function setAuthorizedExtensions(array $extensions) {
        $this->authorized_extensions = $extensions;
    }

    private function check_extension_file() {
        if (isset($this->authorized_extensions) && !empty($this->authorized_extensions)) {
            if (in_array($this->_file_extension, $this->authorized_extensions)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Check $_FILES[][name]
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz
     */
    private function check_file_uploaded_name($filename) {
        return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i", $filename)) ? true : false);
    }

    /**
     * Check $_FILES[][name] length.
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz.
     */
    function check_file_uploaded_length($filename) {
        return (bool) ((mb_strlen($filename, "UTF-8") < 225) ? true : false);
    }

}
