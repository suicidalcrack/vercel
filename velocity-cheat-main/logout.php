<?php

include 'app/require.php';

Session::init();

if (!Session::isLogged()) { Util::redirect('/login'); }

$user = new UserController;
$user->logoutUser();

Util::redirect('/login');