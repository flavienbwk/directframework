<html lang="<?= $Page->getLanguage(); ?>">
    <head>
        <title><?= $Page->getTitle(); ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="simple framework php, multi-language support"/>
        <meta name="author" content="Flavien Berwick"/>
        <meta name="description" content="A very simple and lightweight PHP framework built to save you time by deploying quickly your ideas with a clean code."/>
        <?php
        foreach ($HeaderModel->getCSS_URI() as $ressource) {
            echo $ressource . "\n";
        }
        ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="https://berwick.fr/projects/directframework/"><?= $Page->getConfigVar("website_title"); ?></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="documentation"><?= $Page->getString("navbar_documentation", "Index.header.json") ?></a></li>
                    <li><a href="#" class="uncolored"><?= $Page->getString("navbar_news", "Index.header.json") ?></a></li>
                    <li><a href="#" class="uncolored"><?= $Page->getString("navbar_contact", "Index.header.json") ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</head>