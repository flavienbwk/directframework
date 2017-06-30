<?php

class headerModel {
    private function generateURI($type,$url){
        switch($type){
            case("js"):
                return "<script src=\"assets/js/".$url."\"></script>";
                break;
            case("javascript"):
                return "<script src=\"assets/js/".$url."\"></script>";
                break;
            case("css"):
                return "<link rel=\"stylesheet\" href=\"assets/css/".$url."\"/>";
                break;
            default:
                return "";
        }
    }
    
    public function getCSS_URI(){
        return array(
            '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"'
            . ' integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">',
            $this->generateURI("css","app.css"),
            $this->generateURI("css","main.css"),
            $this->generateURI("css","card.css")
        );
    }
    
    public function getJS_URI(){
        return array(
            '<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" '
            . 'crossorigin="anonymous"></script>',
            '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" '
            . 'integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>',
            $this->generateURI("js","notify.min.js")
        );
    }
}
