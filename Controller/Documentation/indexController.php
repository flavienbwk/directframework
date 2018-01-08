<?php

/*
 * Direct Framework, under MIT license.
 */

/*
 * Direct functions
 */
$Page = new Page();
$Page->setLanguage("en"); // Facultative. 
$Page->setTitle($Page->getString("title_documentation", "Index.index.json") . " - ", true);

/*
 * Models
 * The Autoloader automatically loads the classes.
 */
$HeaderModel = new headerModel();
$FooterModel = new footerModel();

/*
 * Views
 */
require($Page->renderURI("View/Documentation/headerView.php"));
require($Page->renderURI("View/Documentation/indexView.php"));
require($Page->renderURI("View/Index/footerView.php"));
