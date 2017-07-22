<p align="center">
<img src="https://speeload.com/uploads/ae1h6SUhhG.png" width="200">
<p>

# What is it ?
A very simple and lightweight PHP framework which allows you to easily support multi-language for your website, and to quickly deploy its functionalities with a clean code.

_Actual version :_ __ed-0.4__

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
    * Set the "router_url_parameters" option to true into Components/config.json to enjoy the following feature :
        * Now, if you try to access an inexistant URL : for example "/index/test" and that there's no "Controler/Index/testControler.php" file, it will load "Controler/Index/indexControler.php" ("/index") and the parameter "test" will be accessible through _$_GET["path_file"]_.
    * URL correction for root if the slash is missing.
* Components/Direct.class.php :
	* The logs now have a configurable max file size. Change it in Components/config.json at index "log_max_file_size" (in byte).
	* When the max file size is reached for the last log file (saved in Components/log/), Direct.class.php creates a new file.
	* Example of file name : 0.log.json. If max file size exceeded : creating 1.log.json, etc...

[1]: https://berwick.fr/projects/directframework/documentation
[2]: https://berwick.fr/projects/directframework/documentation/support-multi-lang
[3]: #