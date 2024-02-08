<?php
session_start();
session_destroy();
unset($_COOKIE['user']);
setcookie('user', null, -1, '/');
header('Location: /');
exit();
