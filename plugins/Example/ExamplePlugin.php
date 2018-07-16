<?php
/* Example plugin */
class ExamplePlugin extends Plugin{
	public function __construct(){
		//this is required by the plugin system to get working properly. This adds all the below events to global like {Class}::{onEventName};
		parent::__construct(); //Required
		return true;
	}
	
	public function initialize(){
		return true;
	}
	public function onPageLoad($s, &$p){
		
		echo '<div class="alert alert-success">This should be displayed via the Exmaple Plugin!</div>';
		
		return true; //So we continue processing plugins
	}
}
?>