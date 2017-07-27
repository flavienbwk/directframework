<p align="center">
<img src="https://speeload.com/uploads/ae1h6SUhhG.png" width="200">
<p>

# What is it ?
A very simple and lightweight PHP framework which allows you to easily support multi-language for your website, and to quickly deploy its functionalities with a clean code.

_Actual version :_ __ed-0.5__

# Why this one ?
Simple architecture, easy to learn, lightweight, no need to install anything (just upload the framework files), easily support multiple languages and use helpful integrated functionalities (log, notifications...).

Available developer if there's a problem.

Installation & documentation :
------------------------------

* [Get started][1] with Direct Framework. See how easy it is!
* [Support multi-language][2], learn how to do it.
* See the [useful functionalities][3] that Direct integrates to speed up your development process.

Notes of the version :
------------------------------

* Components/Router.php :
    * The _$_GET["parameters"]_ variable handles the parameters given in the URL.
    i.g, f you try accessing "/account/login/8E6DF/1456", the framework will detect that the controler "Controler/Account/loginControler.php" exists and that 8E6DF and 1456 are parameters.
    * Huge patch for the Router.

[1]: https://berwick.fr/projects/directframework/documentation
[2]: https://berwick.fr/projects/directframework/documentation/support-multi-lang
[3]: #