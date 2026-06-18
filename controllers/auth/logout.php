<?php

use Core\Auth;

authorize(isset($_SESSION['user']));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Auth::logout();
    redirect("/");
}
