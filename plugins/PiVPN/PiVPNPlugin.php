<?php
    require 'dashBoard.php';
    class PiVPNPlugin extends Plugin
    {
        $myDashBoard = new dashBoard();

        public function __construct(){
            //this is required by the plugin system to get working properly. This adds all the below events to global like {Class}::{onEventName};
            parent::__construct(); //Required
            return true;
        }

        public function initialize(){
            return true;
        }
        
        public function onDashboardEnd($sess)
        {
            return $myDashBoard.onDashboardEnd($sess);
        }
    }
?>