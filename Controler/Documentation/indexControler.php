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
$Page->setTitle(" - ".$Page->getString("title_documentation","Index.index.json"),true);

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
require($Page->renderURI("View/Documentation/headerView.php"));
require($Page->renderURI("View/Documentation/indexView.php"));
require($Page->renderURI("View/Index/footerView.php"));