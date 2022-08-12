<?php

declare(strict_type = 1);

namespace App\Services;

/**
 * This class manages sessions
 */

class SessionManager
{
    public function sessionStart()
    {
        session_start();
    }
    public function sessionEnd()
    {
        session_unset();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(),'', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
    public function setSessionData(string $sessionKey, $sessionValue)
    {
        $_SESSION[$sessionKey] = $sessionValue;
    }
    public function getSessionData(string $sessionKey)
    {
        if (isset($_SESSION[$sessionKey])) {
            return $_SESSION[$sessionKey];
        }
        return false;
    }
}