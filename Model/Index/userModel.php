<?php

/**
 * THIS FILE IS AN EXAMPLE ON HOW TO USE the databaseModel properly.
 * Knowing that our users are stored in the "User" class.
 */
class userModel extends databaseModel {

    var $_Page;

    public function __construct($Page) {
        parent::__construct();
        $this->_Page = $Page;
    }

    /**
     * For example, if you want to select your 'User' by its 'id' of value '1',
     * you will run this code : $userModel->getUserBy(["id" => 1])
     * 
     * @param type $data
     * @return array|boolean Returns an array of the results or false if not found.
     */
    public function getUserBy($data) {
        return $this->select("User", $data);
    }

    public function getUsersBy($data) {
        return $this->selectAll("User", $data);
    }

    public function createUser($data) {
        return $this->insert("User", $data);
    }

}
