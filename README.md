<p align="center">
<img src="https://speeload.com/uploads/ae1h6SUhhG.png" width="200">
<p>

# What is it ?
A very simple and lightweight PHP framework which allows you to easily support multi-language for your website, and to quickly deploy its functionalities with a clean code.

_Actual version :_ __ed-0.3__

# Why this one ?
Simple architecture, easy to learn, lightweight, no need to install anything (just upload the framework files), easily support multiple languages. Available developer if there's a problem.

Installation & documentation :
------------------------------

* [Get started][1] with Direct Framework. See how easy it is!
* [Support multi-language][2], learn how to do it.
* See the [useful functionalities][3] that Direct integrates to speed up your development process.

Notes of the version (ed-0.3) :
------------------------------
* Modified Direct.class.php so you can access the $_GET variable normally.
* Added an easy notification system with _$Page->addInfo(string)_ or _$Page->addError(string)_ and shows them with _$Page->showNotifications()_ (documentation soon).
* Fixed original controler for this repository (Controler/Index/indexControler.php).
* Added a log system (use _$Page->addToLog(string $content, facultative string $title, facultative array $options);_).
* Added a follow path system : specify a path with _$Page->setFollowPath(array $paths);_ and header to the set paths with _$Page->goFollowPath();_ ! Useful if you need to redirect the users.
* Added several integrated functions to the framework :
	* _(bool) $Page->isJson(string);_ so you can easily check if a JSON string is valid.
	* _(bool) $Page->is_post(array);_ to check the existance of multiple $_POST inputs (replace _isset()_).
	* _(bool) $Page->is_post_not_empty(array);_ to check the emptiness of multiple $_POST inputs (replace _!empty()_).
	* _(string) $Page->getIp();_ to get the IP of the user.

[1]: https://berwick.fr/projects/directframework/documentation
[2]: https://berwick.fr/projects/directframework/documentation/support-multi-lang
[3]: #