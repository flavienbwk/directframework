<?php

/* 
 * Direct Framework, under MIT license.
 */

/*
 * Direct functions
 * DO NOT REMOVE
 */
require(dirname(__FILE__)."/../../Components/Page.class.php");
$Page = new Page();

/*
 * Models (facultative)
 */
require($Page->renderURI("View/Index/indexIndex.php"));
$indexModel = new indexModel();

/*
 * Views
 */
require($Page->renderURI("View/Index/indexIndex.php"));