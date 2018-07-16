<?php
//Stupid simple aint it?
class Plugin
{
    function __construct()
    {
		//Default Events
        Event::addHandler('InitializePlugin', array($this, 'initialize'));
        foreach (get_class_methods($this) as $method) {
            if (mb_substr($method, 0, 2) == 'on') {
                Event::addHandler(mb_substr($method, 2), array($this, $method));
            }
        }

    }

    function initialize()
    {
        return true;
    }
}

