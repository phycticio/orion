<?php

/**
 * Theme actions.
 */

namespace App;

foreach(glob(__DIR__ . "/actions/*.php") as $action_file) {
    if(is_file($action_file))
        require_once $action_file;
}