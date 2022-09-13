<?php

declare(strict_types = 1);

namespace App\Services;

/**
 * This class manages sessions
 */

class SessionManager
{
    public static function sessionStart()
    {
        session_start();
    }
    public static function sessionEnd()
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

    /**
     * Set session key/value pair
     * @param string $sessionKey
     * @param string $sessionValue
     */
    public static function setSessionData(string $sessionKey, $sessionValue)
    {
        $_SESSION[$sessionKey] = $sessionValue;
    }

    /**
     * Returns session value by key
     */
    public function getSessionData(string $sessionKey)
    {
        if (isset($_SESSION[$sessionKey])) {
            return $_SESSION[$sessionKey];
        }
        return false;
    }
}