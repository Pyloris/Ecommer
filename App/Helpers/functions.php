<?php

// unset session keys
function unset_session($keys) {
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    foreach($keys as $key) {
        unset($_SESSION[$key]);
    }
}

?>