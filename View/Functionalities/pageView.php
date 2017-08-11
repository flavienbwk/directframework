<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="jumbotron">
                <h2>Useful functionalities.</h2>
                <p>Gain much time with those built-in functions.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Jump to what interests you !</h3>
                </div>
                <div class="card-block">
                    <ul>
                        <li><a href="#notifications_system">Notifications system</a></i>
                        <li><a href="#log_system">Log system</a></i>
                        <li><a href="#post_functions">$_POST variables functions</a></i>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <p>All theses built-in functionalities are available as you include the <code>Page</code> class, present in <code>Components/Page.class.php</code>.</p>
                    <p>
                        So, all the functions can be called using anywhere on your pages : <code>$Page-><i>name_of_the_function</i>();</code>.
                    </p>
                    <div class="label label-default">(returned type)</div>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <div class="label label-default">(void)</div>
                    <h3><code>$Page->setTitle(string $title [, bool $config_title]);</code></h3>
                    <p>Set the title of your current page. Use it in the controler.</p>
                    <p>If <code>$config_title</code> is set to true, <code>setTitle()</code> returns the <i>$title</i> concatenated with the <i>website_title</i>, present in the <i>Components/config.json</i> config file.</p>
                    <p>Then, call <code>$Page->getTitle();</code> in your view to get it.</p>
                </div>
            </div>
            <div class="card" id="notifications_system">
                <div class="card-header" style="text-align:center;">
                    <h4>[ Notifications system ]</h4>
                    <p>Three functions, easy to use, easy to custom.</p>
                </div>
                <div class="card-block">
                    <div class="label label-default">(void)</div>
                    <h3><code>$Page->addInfo(string $title, string $message);</code></h3>
                    <div class="direct-info-frame">
                        <span class="info-title">Breakings! </span>
                        <span class="info-content">An incredible framework!</span>
                    </div>
                    <h3><code>$Page->addError(string $title, string $message);</code></h3>
                    <div class="direct-error-frame">
                        <span class="error-title">Wow!</span>
                        <span class="error-content">It's dangerous here!</span>
                    </div>
                    <ul>
                        <li>$title = the title (shown in bold).</li>
                        <li>$message = the message (shown as a paragraph below the title).</li>
                    </ul>
                    <hr/>
                    <h3><code>$Page->showInfos([bool $remove_notifs=true]);</code></h3>
                    <p>Only shows infos, and removes them if $remove_notifs is not <code>false</code>.</p>
                    <h3><code>$Page->showErrors([bool $remove_notifs=true]);</code></h3>
                    <p>Only shows errors, and removes them if $remove_notifs is not <code>false</code>.</p>
                    <h3><code>$Page->showNotifications([bool $remove_notifs=true]);</code></h3>
                    <p>Shows both errors and infos, and removes them if $remove_notifs is not <code>false</code>.</p>
                    <hr/>
                    <p>You can cumulate the notifications :</p>
                    <pre>
$Page->addError("Title 1", "Blablabla");
$Page->addError("Title 2", "Blobloblo");
$Page->showNotifications();
                    </pre>
                    <p>Will output :</p>
                    <div class="direct-error-frame">
                        <span class="error-title">Title 1</span>
                        <span class="error-content">Blablabla</span>
                    </div>
                    <div class="direct-error-frame">
                        <span class="error-title">Title 2</span>
                        <span class="error-content">Blobloblo</span>
                    </div>
                    <br/>
                    <p>You can edit the styles in <code>Components/assets/css/app.css</code>.</p>
                </div>
            </div>
            <div class="card" id="log_system">
                <div class="card-header" style="text-align:center;">
                    <h4>[ Log system ]</h4>
                    <p>One function, powerful options.</p>
                </div>
                <div class="card-block">
                    <h3><code>$Page->addToLog(string $content[,string $title [,array $options]]);</code></h3>
                    <ul>
                        <li>$content : the description of the event.</li>
                        <li>$title : the title of the event.</li>
                        <li>$options : classic/associative array.</li>
                    </ul>
                    <p>Add a log line. Logs are stored under <code>Components/log/x.log.json</code> (x starts at 0). Here is an example of how one entry looks like :</p>
                    <pre>
    Using:
    ------
    $Page->addToLog("User trying to access a non-authorized ressource.",
                    "User denied !",
                    array("ip", "custom_data" => "Blabla", "custom_data_empty")
                   );

    Creates :
    ------
    [{
        "title": "User denied !",
        "options": [
                        {
                            "f_name": "ip",
                            "content": "84.xxx.xxx.xxx"
                        },
                        {
                            "f_name": "my_custom_data",
                            "content": "Blabla"
                        },
                        {
                            "f_name": "custom_data_empty",
                            "content": ""
                        }
                    ],
        "content": "User trying to access a non-authorized ressource.",
        "date": "18:33 26\/07\/2017",
        "timestamp": 1501086799
    }]
                    </pre>
                    <p>As you can see, the "ip" option automatically attributes the IP of the client as its content. Here are the available option names that auto-fill with corresponding data :</p>
                    <ul>
                        <li>"ip" : IP of the user.</li>
                        <li>"backtrace" : File from where is called addToLog().</li>
                    </ul>
                    <p>You can specify a max file size for one log file by attributing to the "log_max_file_size" option, a max value in octet (4096 by default), in the <code>Components/config.json</code> file.<br/>If the current log file exceeds that value, a new one will be create and logs will be written in.</p>
                    <p>You can deactivate the log system by putting "yes" in the "log_disable" option in the <code>Components/config.json</code> file.</p>
                </div>
            </div>
            <div class="card" id="post_functions">
                <div class="card-header" style="text-align:center;">
                    <h4>[ $_POST variables functions ]</h4>
                </div>
                <div class="card-block">
                    <div class="label label-default">(bool)</div>
                    <h3><code>$Page->is_post(array $post_parameters_to_check);</code></h3>
                    <p>Replaces the <code>isset($_POST["<i>parameter_name</i>"])</code> function. Example :</p>
                    <pre>
Before:
if(isset($_POST["input_1"])&&isset($_POST["input_2"])&&isset($_POST["input_3"])[...]){true}

Now:
if($Page->is_post(array("input_1","input_2","input_3",[...]))){true}
                    </pre>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <div class="label label-default">(bool)</div>
                    <h3><code>$Page->is_post_not_empty(array $post_parameters_to_check);</code></h3>
                    <p>Replaces the <code>isset($_POST["<i>parameter_name</i>"])&&!empty($_POST["<i>parameter_name</i>"])</code> functions. Example :</p>
                    <pre>
Before:
if(isset($_POST["input_1"])&&!empty($_POST["input_1"])&&isset($_POST["input_2"])&&!empty($_POST["input_2"])[...]){true}

Now:
if($Page->is_post_not_empty(array("input_1","input_2",[...]))){true}
                    </pre>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <div class="label label-default">(void)</div>
                    <h3><code>$Page->post_variables_init(array $post_params_to_declare);</code></h3>
                    <p>This function declares the $_POST variables declared in the array. Pretty useful when you have to deal with many post parameters.</p>
                    <pre>
Before :
$input_1=$_POST["input_1"];
$input_2=$_POST["input_2"];
[...]

Now :
$Page->post_variables_init(array("input_1","input_2",[...])); // POST parameters are declared with their name as variable.
var_dump($input_1); // Will output the value of $_POST["input_1"]
var_dump($input_2); // Will output the value of $_POST["input_2"]

                    </pre>
                </div>
            </div>
            <div class="card" id="others">
                <div class="card-header" style="text-align:center;">
                    <h4>[ Others ]</h4>
                    <p>A lot of small but useful functions.</p>
                </div>
                <div class="card-block">
                    <div class="label label-default">(string)</div>
                    <h3><code>$Page->getIp();</code></h3>
                    <p>Returns the IP address of the user.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <div class="label label-default">(undefined)</div>
                    <h3><code>$Page->moreFunctionsSoon();</code></h3>
                    <p>=)</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>