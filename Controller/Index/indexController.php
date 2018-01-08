<?php

/* 
 * Direct Framework, under MIT license.
 */

/*
 * Direct functions
 */
$Page = new Page();
$Page->setLanguage("en"); // Facultative. 
$Page->setTitle($Page->getString("welcome")." - ", true);

/*
 * Models
 */
$HeaderModel = new headerModel();
$FooterModel = new footerModel();

/*
 * Views
 */
require($Page->renderURI("View/Index/headerView.php"));
require($Page->renderURI("View/Index/indexView.php"));
require($Page->renderURI("View/Index/footerView.php"));