<?php
/*
 * Direct Framework, under MIT license.
 */
?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="download">
                <center>
                    <h1>Downloading & installing</h1>
                    <p>
                        Direct does not use third-party library.
                        <br/>
                        No configuration needed relative to the server. Direct uses relative paths.
                        <br/>
                        So you can just upload the files of the framework on your server.
                    </p>
                </center>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Download the classic repository.</h2>
                <p>The ready-to-use files for your new project. Get the last version on GitHub.</p>
                <br/>
                <a href="https://github.com/flavienbwk/directframework" target="_blank"><pre>https://github.com/flavienbwk/directframework</pre></a>
            </div>
            <div class="col-lg-6">
                <h2>Download the example repository.</h2>
                <p>This repository contains the files of this website, built with Direct, so you can have examples of how to use Direct.</p>
                <br/>
                <a href="https://github.com/flavienbwk/directframework/tree/documentation-example" target="_blank"><pre>https://github.com/flavienbwk/directframework/tree/documentation-example</pre></a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <hr/>
                <div class="col-lg-offset-2 col-lg-8" id="architecture">

                    <div class="tutorial-part">
                        <h1>Get started!</h1>
                        <h2>The structure.</h2>
                        <p>Direct uses the Model-View-Controler architecture to facilitate the understanding of your code by another developer and to organize that code.</p>
                        <table class="table">
                            <tr><th>Model</th><td>A php class which will proceed to the computation (calculus, functions etc...). This is the brain part.</td></tr>
                            <tr><th>View</th><td>A php file which will include all the HTML of your page, calling the model class functions to render the informations you want.</td></tr>
                            <tr><th>Controler</th><td>Used to include your models and views. This is this file which will be called by the Router so your view can the shown to the user.</td></tr>
                        </table>
                        <p>
                            These three components have their own repositories at the root of the project. Here's how it is organized and the nomenclature to respect.
                        </p>
                        <h3>MVC structure.</h3>
                        <pre>
    ./Components
        [This directory contains the Direct classes, traduction files and assets]
    ./Controler
        ./Index
            indexControler.php [Compulsory file]
            whatyouwantControler.php
    ./Model
        ./Index
            indexModel.php
            whatyouwantModel.php 
    ./View
        ./Index
            indexView.php
            whatyouwantView.php
    .htaccess
                        </pre>
                        <p>
                            Inside <code>Controler/</code>, <code>Model/</code> and <code>View/</code>, you see there's a <code>Index/</code> folder.
                            <br/>
                            This Index folder is obligatory. It is called when normally calling your index.php root file.
                            <br/>
                        <div class="alert">
                            <div class="col-lg-1"><img src="assets/images/warning.png" class="alert-img"/></div>
                            <div class="col-lg-11">
                                <b>When someone arrives on the index of your website, <code>Controler/Index/indexControler.php</code> will be called. So make sure it is always existent.</b>
                            </div>
                        </div>
                        </p>
                    </div>
                    <div class="tutorial-part">
                        <h4>Create a new page</h4>
                        <p>
                            You have to respect the following nomenclatures to create a new php page (here, called "pagenameyouwant") :
                        </p>
                        <table class="table">
                            <tr><th>Views</th><td><i>Inside</i> <div class="pre-uncolored">View<b>/</b><span class="uncolored"><span class="span-important">WhatYouWant-Folder</span><b>/</b><b><span class="span-important">pagenameyouwant</span>View.php</span></b></div></td></tr>
                            <tr><th>Models</th><td><i>Inside</i> <div class="pre-uncolored">Model<b>/</b><span class="uncolored"><span class="span-important">WhatYouWant-Folder</span><b>/</b><b><span class="span-important">pagenameyouwant</span>Model.php</span></b></div></td></tr>
                            <tr><th>Controlers</th><td><i>Inside</i> <div class="pre-uncolored">Controler<b>/</b><span class="uncolored"><span class="span-important">WhatYouWant-Folder</span><b>/</b><b><span class="span-important">pagenameyouwant</span>Controler.php</span></b></div></td></tr>
                        </table>
                        <p>
                            To have a more organized code, for each view, you have to create a corresponding controler and model file as shown just up. But this is facultative.
                        </p>
                    </div>
                    <div class="tutorial-part">
                        <h4>Example : create a new page.</h4>
                        <p class="question">What do we want ?</p>
                        <p class="answer">We want to access the following URL where we would like to display our articles : <div class="pre-uncolored">(https://)example.com/<span class="green">forum</span>/<span class="red">articles</span></div>.</p>
                        <ol>
                            <li>Create the <span class="green">folder</span> and <span class="red">file</span> <div class="pre-uncolored">./Controler/<span class="green">Forum</span>/<span class="red">articlesControler.php</span></div></li>
                            <li>Create the <span class="green">folder</span> and <span class="red">file</span> <div class="pre-uncolored">./Model/<span class="green">Forum</span>/<span class="red">articlesModel.php</span></div></li>
                            <li>Create the <span class="green">folder</span> and <span class="red">file</span> <div class="pre-uncolored">./View/<span class="green">Forum</span>/<span class="red">articlesView.php</span></div></li>
                        </ol>
                        <div class="alert">
                            <div class="col-lg-1"><img src="assets/images/warning.png" class="alert-img"/></div>
                            <div class="col-lg-11">
                                For example here, accessing <div class="pre-uncolored-small">(https://)example.com/<span class="green">forum</span></div> will make the framework run <div class="pre-uncolored-small">(https://)example.com/Controler/<span class="green">Forum</span>/<b>indexControler.php</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="tutorial-part">
                        <h4>Example : fill the controler (call the views).</h4>
                        <p class="question">What do we want ?</p>
                        <p class="answer">We want the controler to load our models and our views. For example, we will load our navbar and footer in addition to our articles page.</p>
                        <ol>
                            <li>
                                Create the <b>header</b> and <b>footer</b>
                                <span class="green">folders</span> and <span class="red">files</span>. For example, the <b>header</b> will require the following files (the model is facultative) :
                                <ul>
                                    <li>
                                        <div class="pre-uncolored">./Controler/<span class="green">Forum</span>/<span class="red">headerControler.php</span></div>
                                    </li>
                                    <li>
                                        <div class="pre-uncolored">./Model/<span class="green">Forum</span>/<span class="red">headerModel.php</span></div>
                                    </li>
                                    <li>
                                        <div class="pre-uncolored">./View/<span class="green">Forum</span>/<span class="red">headerView.php</span></div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <p>We have then to include these models and views in the articles controler <b>./Controler/Forum/articlesControler.php</b>.</p>
                                <div class="pre-uncolored">
                                    <?php highlight_string(file_get_contents($Page->renderURI("Controler/Documentation/assets/example." . $Page->getLanguage() . ".php"))); ?>
                                </div>
                            </li>
                            <li>
                                Well, hmm... That's all! Access <div class="pre-uncolored">yourwebsite.com/forum/articles</div>.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>