<p align="center">
<img src="https://speeload.com/uploads/ae1h6SUhhG.png" width="200">
<p>

# What is it ?
A very simple and lightweight PHP framework built to save you time by deploying quickly your ideas with a clean code.

_Actual version :_ __ed-0.10__

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

* Components/config.json :
	* Added the possibility to disable the logs via the "log_disable" option.
* Components/Direct.class.php :
	* Fixed session already started.
	* Fixed error when the log directory doesn't exist.
	* Added possibility to create custom informations in logs. Example : $Page->addToLog($my_content,$my_title,array("my_custom_information"=>"Hey what's up ?"));
* Components/assets/css/app.css :
	* Fixed bold titles for notifications.
* Documentation :
	* Added the useful functionalities.
* Modified description.


[1]: https://berwick.fr/projects/directframework/documentation
[2]: https://berwick.fr/projects/directframework/documentation/support-multi-lang
[3]: https://berwick.fr/projects/directframework/functionalities/page/