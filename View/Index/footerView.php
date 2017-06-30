<footer class="footer">
    <div class="container">
        <span class="text-muted">Made with <b><3</b> by Flavien Berwick, with <b>Direct Framework</b>.</span>
    </div>
    
    <?php
    foreach ($HeaderModel->getJS_URI() as $ressource) {
        echo $ressource . "\n";
    }
    ?>
</footer>
</html>