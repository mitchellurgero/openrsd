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

#### onPageLoad($sess, &$post)

This function is called on *every* page load.

#### onPageLoadEnd($sess, &$post)

This function is called when a page is done loading.

#### onDashboardEnd($sess)

This function is called when the dashboard is done loading, perfect for adding custom panel blocks, or other information to the Dashboard page specifically.

#### onLoginStart($sess, &$post)

This function is called when a user attempts to login.

#### onLoginError($sess, &$post)

This function is called whenever there is an error logging in (Bad password, Error in backend, etc). (Disable accounts for login, ban IP's, etc.)

#### onLoginSuccess($sess, &$post)

This function is called whenever a login is successful.

#### onLoginEnd($sess, &$post)

This function is called when login is finished (Error or success).

#### onHeadEnd($sess)

This function is called at the end of the `<head>` tag. Useful for adding custom CSS (Like themes!)

#### onFootEnd($sess)

This function is called at the end of the footer (End of `<body>` tag). Useful for adding custom JavaScript.

#### onCustomPage($sess, &$post)

This function is called when a system page is not being called. Allows for custom pages to be made with plugins instead of being added to the pages folder. This function MUST return `CUSTOM` or it will fail to load and will report a `404`.

#### onCustomPageLinks($sess)

This function can add links to the top menu under the `Custom Pages` drop down.

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