<?php

authorize(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin');
