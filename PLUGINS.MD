## Basic Plugin System based off GNU/Social Plugin System

### 1. Configuring OpenRSD to load plugins

Configuration is simple:

1. Create a new file called "loadPlugins.php" in the root of the OpenRSD folder.
2. Inside that file put:

```
<?php
addPlugin("Example");
?>
```
Where `Example` is the name of the plugin you want to load. You can add more plugins using the `addPlugin()` function as shown. (This function can be called multiple times.)

### Making a plugin

Using the Plugin class, you can modify many parts of OpenRSD. This part of the documentation will be completed later.

### plugin functions

Below are the currently available function calls available to plugins

#### onPageLoad($_SESSION, &$_POST)

This function is called on *every* page load.

### Example Plugin

This example plugin creates an "alert" at the top of each page load.

```
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
	public function onPageLoad(&$s, &$p){
		
		echo '<div class="alert alert-success">This shoud be displayed va the Exmaple Plugin!</div>';
		
		return true; //So we continue processing plugins
	}
}
?>
```