<?php

/* 
 * Direct Framework, under MIT license.
 */

/*
 * Direct functions
 */
$Page = new Page();
$Page->setLanguage("en"); // Facultative. 
$Page->setTitle(" - ".$Page->getString("title_documentation_multilang","Index.support-multi-lang.json"));

/*
 * Models
 */
require($Page->renderURI("Model/Index/headerModel.php")); 
$HeaderModel = new headerModel();
require($Page->renderURI("Model/Documentation/support-multi-langModel.php"));
$IndexModel = new supportmultilangModel();
require($Page->renderURI("Model/Index/footerModel.php"));
$FooterModel = new footerModel();

/*
 * Views
 */
require($Page->renderURI("View/Documentation/headerView.php"));
require($Page->renderURI("View/Documentation/support-multi-langView.php"));
require($Page->renderURI("View/Index/footerView.php"));