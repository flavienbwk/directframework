<?php

/*
 * Direct Framework, under MIT license.
 */

/*
 * Direct functions
 */
require(dirname(__FILE__)."/../../Components/Page.class.php");
$Page = new Page();
$Page->setLanguage("en"); // Facultative. 
$Page->setTitle("Useful functionalities - ",true);

/*
 * Models
 */
require($Page->renderURI("Model/Index/headerModel.php")); 
$HeaderModel = new headerModel();
require($Page->renderURI("Model/Documentation/indexModel.php"));
$IndexModel = new indexModel();
require($Page->renderURI("Model/Index/footerModel.php"));
$FooterModel = new footerModel();

/*
 * Views
 */
require($Page->renderURI("View/Index/headerView.php"));
require($Page->renderURI("View/Functionalities/pageView.php"));
require($Page->renderURI("View/Index/footerView.php"));