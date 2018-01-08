<?php

/* 
 * CONTROLER FILE.
 * Controler/Forum/articlesControler.php
 */

/*
 * The two following lines are really important.
 * Make sure you have inclued them.
 */
/*
 * The following require() is useless since beta-0.1 as Autoloader automatically loads the Page class :
 * require(dirname(__FILE__)."/../../Components/Page.class.php");
 */
$Page = new Page();

// ========================================

/*
 * Models
 * Models are facultative files. For example, if you
 * just have to display a view, you don't necessarily
 * have to use a model.
 */
// Calling a model, a view or any file must take the following syntax.
// "require($Page->renderURI("path_to_the_file"));"
require($Page->renderURI("Model/Forum/headerModel.php")); // Including the header model.
$HeaderModel = new headerModel();
require($Page->renderURI("Model/Forum/articlesModel.php")); // Including the article model.
$IndexModel = new indexModel();
require($Page->renderURI("Model/Forum/footerModel.php")); // Including the footer model.
$FooterModel = new footerModel();

// ========================================

/*
 * Views
 * Including the views to display.
 */
require($Page->renderURI("View/Forum/headerView.php")); // View of the navbar and header infos.
require($Page->renderURI("View/Forum/articlesView.php")); // View of the articles.
require($Page->renderURI("View/Forum/footerView.php")); // View of the footer.

// ========================================