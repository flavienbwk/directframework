<?php
/*
 * Direct Framework, under MIT license.
 */
?>
<div class="container">
    <div class="row">
        <center>
            <h1>Multi-lang support.</h1>
            <h4>Let's learn how to enjoy the easy multi-lang functionality of Direct!</h4>
            <hr/>
        </center>
    </div>
    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">

            <div class="tutorial-part">
                <h2>Explanations</h2>
                <p>Briefly : you will enter the line <code>$Page->setLanguage("lang_you_want")</code>, in which <i>lang_you_want</i> is the language you want in the ISO nomenclature (for example : english is "en", french is "fr"...) in your <b>controller file</b>, after declaring the <i>Page</i> class.</p>
                <div class="pre-uncolored">
                    /*
                    * For example in Controller/Index/indexController.php
                    */
                    <br/>
                    <br/>
                    <div class="uncolored">
                        $Page = new Page(); // Declaring Page class
                    </div>
                    $Page->setLanguage("en"); // Setting the language
                </div>
            </div>
            <div class="tutorial-part">
                <h3>Translation files.</h3>
                <p>OK, you've selected a language, now you have to know where are translations stored and how translation files are working.</p>
                <h4>Create the translation repository</h4>
                <p>Translation files are stored under <code>./Components/langs/</code>.</p>
                <p>In this directory, you will have the choice to create directories depending on which language you want.</p>
                <p>For example for the english language, you need to create an <code>en/</code> directory. So the complete path to your translation directory will be <code>./Components/langs/en/</code>.</p>
            </div>

            <div class="tutorial-part">
                <h4>Create the translation files</h4>
                <p>Create a new file inside <code>./Components/langs/en/</code>. Here is the nomenclature to respect (facultative if you use the first way to call your translation file) :</p>
                <div class="pre-uncolored"><span class="green">FolderName</span>.<span class="red">fileViewName</span>.json</div>
                <p>For example, we have the index view file under <code>./View/<span class="green">Index</span>/<span class="red">index</span>View.php</code>, the correct nomenclature for the translation file will be <code><span class="green">Index</span>.<span class="red">index</span>.json</code>.</p>
            </div> 


            <div class="tutorial-part">
                <h4>Content of the translation files</h4>
                <p>
                    Translation files are json files. So syntax is simple. Here is an example.
                </p>
                <p>Inside <code>./Components/langs/en/Index.index.json</code> :</p>
                <pre>{
    "greetings":"Hello!",
    "framework_name":"My name is Direct Framework"
}</pre>
            </div>

            <div class="tutorial-part">
                <h4>Calling the translations</h4>
                <p>Translations are used whether in views or in models. There are two ways to call the translations.</p>
                <br/>
                <ul>
                    <li>
                        <p>Query the translation with the file name. In any <b>view</b> or <b>model</b>, put :</p>
                        <div class="pre-uncolored">
                            <?php highlight_string(file_get_contents($Page->renderURI("Controller/Documentation/assets/example-translation." . $Page->getLanguage() . ".php"))); ?>
                        </div>
                        <p>Here, the file called is <code>./Components/langs/en/<b>Index.index.json</b></code>.</p>
                    </li>
                    <br/>
                    <li>
                        <p>Directly query the string from a <b>view</b> (here from the <code><b><i>Index/indexView.php</i></b></code> view).</p>
                        <i><p>The translation file name must respect the nomenclature given before.</p></i>
                        <pre><?php highlight_string(file_get_contents($Page->renderURI("Controller/Documentation/assets/example-translation-simple." . $Page->getLanguage() . ".php"))); ?></pre>
                        <p>Here, the framework directly detects where is the translation called from, and attributes the translation file to look for as <code>./Components/langs/en/<b>Index.index.json</b></code>. </p>
                    </li>
                </ul>

            </div>

            <div class="tutorial-part">
                <p>Now you are up to start building your website with any language! You can put as many languages as you want.</p>
                <div class="alert alert-info">
                    Need help ? <a href="#">Contact the developer</a> !
                </div>
            </div>
        </div>
    </div>
</div>
</div>