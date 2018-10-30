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
	public function onCustomPageLinks($sess){
		echo '<li><a href="#" onclick="pageLoad(\'example\');"><i class="fa fa-check"></i> Example Custom Page</a></li>';
		return true;
	}
	
	public function onCustomPage($sess,&$post){
		
		//Be careful not to override system pages.
		if($post['page'] == "example"){
			echo "<h3>This is an example custom page!</h3>";
		}
		return true;
	}
}
?>