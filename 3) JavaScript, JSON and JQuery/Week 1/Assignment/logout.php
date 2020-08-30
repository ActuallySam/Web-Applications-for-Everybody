<?php // line 1 added to enable color highlight

session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);
header('Location: index.php');