<?php
require_once 'core/init.php';

$user = new User();
$user->logOut();
Redirect::to('user-login.php');