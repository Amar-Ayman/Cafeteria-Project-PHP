<?php

authorize(isset($_SESSION['user']));

view('user/home.view.php', [
    'title' => 'Welcome to Sereno',
    'header' => 'Home'
]);
