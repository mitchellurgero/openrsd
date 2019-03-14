<?php
    public function __construct(){
        //this is required by the plugin system to get working properly. This adds all the below events to global like {Class}::{onEventName};
        parent::__construct(); //Required
        return true;
    }

    public function initialize(){
        return true;
    }
    public function onPageLoadEnd($sess, &$post)
    {
        if($post == "")
        {    
            echo '<div class="alert alert-success">This will be my new dashboard!</div>';
        }
    }

?>