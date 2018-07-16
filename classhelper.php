<?php

class ClassHelper {
	protected static $plugins = array();
	public static function addPlugin($name, array $attrs=array())
	    {
	        $name = ucfirst($name);
	
	        if (isset(self::$plugins[$name])) {
	            // We have already loaded this plugin. Don't try to
	            // do it again with (possibly) different values.
	            // Försten till kvarn får mala.
	            return true;
	        }
	
	        $pluginclass = "{$name}Plugin";
	
	        if (!class_exists($pluginclass)) {
	
	            $files = array("{$pluginclass}.php");
	
	            foreach ($files as $file) {
	                $fullpath = __DIR__.'/plugins/'.$name.'/'.$file;
	                if (@file_exists($fullpath)) {
	                    include_once($fullpath);
	                    break;
	                } else{
	                	//echo "Failed to load ".$file."<br>";
	                	return false;
	                }
	            }
	            if (!class_exists($pluginclass)) {
					return false;
	            }
	        }
	
	        // Doesn't this $inst risk being garbage collected or something?
	        // TODO: put into a static array that makes sure $inst isn't lost.
	        $inst = new $pluginclass();
	        foreach ($attrs as $aname => $avalue) {
	            $inst->$aname = $avalue;
	        }
	
	        // Record activated plugins for later display/config dump
	        self::$plugins[$name] = $attrs;
	        return true;
	    }

}
