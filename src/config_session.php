<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_start();

if (!isset($_SESSION["last_regeneration"])){
    regenerateSessionId();
    $interval = 60 * 30;
    if(time() - $_SESSION["last_regeneration"] >= $interval){
        regenerateSessionId();
    }
}

function regenerateSessionId () {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

// Define base URL
define('BASE_URL', ($_SERVER['SERVER_NAME'] === 'localhost') ? '/php-SMS2' : '');
echo BASE_URL;
