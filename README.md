<p align="center">
<img src="https://speeload.com/uploads/ae1h6SUhhG.png" width="200">
<p>

# What is it ?
A very simple and lightweight PHP framework built to save you time by deploying quickly your ideas with a clean code.

_Actual version :_ __beta-0.3__

# Why this one ?
Simple architecture, easy to learn, lightweight, no need to install anything (just upload the framework files), easily support multiple languages and helpful built-in functionalities (log, notifications...).

Available developer if there's a problem.

Installation & documentation :
------------------------------

* [Get started][1] with Direct Framework. See how easy it is!
* [Support multi-language][2], learn how to do it.
* See the [useful functionalities][3] that Direct integrates to speed up your development process.

Notes of the version :
------------------------------
* Fixed missing assets file extensions in .htaccess. Now, even if the extension is uppercase, it can be accessed.
* Added possibility to include a ressource (CSS or JS) easily and properly with the $Page->addRessource(array(array($link,"css"),array($link,"js")[...])); function. Get them with $Page->getRessource("css") for css or $Page->getRessource("js") for JS; these functions will generate the appropriate tags to include the links.

[1]: https://berwick.fr/projects/directframework/documentation
[2]: https://berwick.fr/projects/directframework/documentation/support-multi-lang
[3]: https://berwick.fr/projects/directframework/functionalities/page/