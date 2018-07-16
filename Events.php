<?php


//How to use: Event::handle('OtherAccountProfiles', array($user->getProfile(), &$relMes));

class Event {

    /* Global array of hooks, mapping eventname => array of callables */

    protected static $_handlers = array();

    /**
     * Add an event handler
     * @param string   $name    Name of the event
     * @param callable $handler Code to run
     *
     * @return void
     */

    public static function addHandler($name, $handler) {
        if (array_key_exists($name, Event::$_handlers)) {
            Event::$_handlers[$name][] = $handler;
        } else {
            Event::$_handlers[$name] = array($handler);
        }
    }

    /**
     * Handle an event
     *
     * Events are any point in the code that we want to expose for admins
     * or third-party developers to use.
     *
     * We pass in an array of arguments (including references, for stuff
     * that can be changed), and each assigned handler gets run with those
     * arguments. Exceptions can be thrown to indicate an error.
     *
     * @param string $name Name of the event that's happening
     * @param array  $args Arguments for handlers
     *
     * @return boolean flag saying whether to continue processing, based
     *                 on results of handlers.
     */

    public static function handle($name, array $args=array()) {
        $result = null;
        if (array_key_exists($name, Event::$_handlers)) {
            foreach (Event::$_handlers[$name] as $handler) {
                $result = call_user_func_array($handler, $args);
                if ($result === false) {
                    break;
                }
            }
        }
        return ($result !== false);
    }

    /**
     * Check to see if an event handler exists
     *
     * Look to see if there's any handler for a given event, or narrow
     * by providing the name of a specific plugin class.
     *
     * @param string $name Name of the event to look for
     * @param string $plugin Optional name of the plugin class to look for
     *
     * @return boolean flag saying whether such a handler exists
     *
     */

    public static function hasHandler($name, $plugin=null) {
        if (array_key_exists($name, Event::$_handlers)) {
            if (isset($plugin)) {
                foreach (Event::$_handlers[$name] as $handler) {
                    if (get_class($handler[0]) == $plugin) {
                        return true;
                    }
                }
            } else {
                return true;
            }
        }
        return false;
    }

    public static function getHandlers($name)
    {
        return Event::$_handlers[$name];
    }

    /**
     * Disables any and all handlers that have been set up so far;
     * use only if you know it's safe to reinitialize all plugins.
     */
    public static function clearHandlers() {
        Event::$_handlers = array();
    }
}

