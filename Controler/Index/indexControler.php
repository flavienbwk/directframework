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
require($Page->renderURI("Model/Index/indexModel.php"));
$indexModel = new indexModel();

/*
 * Views
 */
require($Page->renderURI("View/Index/headerView.php"));
require($Page->renderURI("View/Index/indexView.php"));
require($Page->renderURI("View/Index/footerView.php"));