<?php

namespace Core;

class Auth
{
    public static function check()
    {
        return isset($_SESSION["user"]);
    }

    public static function user()
    {
        return $_SESSION["user"] ?? null;
    }

    public static function login($user)
    {
        $_SESSION["user"] = $user;
        session_regenerate_id(true);
    }

    public static function logout()
    {
        $_SESSION = [];
        session_destroy();

        $params = session_get_cookie_params();
        setcookie("PHPSESSID", 
        "", 
        time() - 3600, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
    }
}
