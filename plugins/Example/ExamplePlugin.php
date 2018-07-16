<?php
/* Example plugin that can turn certain pages into blog posts */
class ExamplePlugin extends Plugin{
	public function __construct(){
		//this is required by the plugin system to get working properly. This adds all the below events to global like {Class}::{onEventName};
		parent::__construct(); //Required
		return true;
	}
	
	public function initialize(){
		return true;
	}
	
}
?>