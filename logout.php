<?php
session_start();
require_once 'classes/Auth.php';

Classes\Auth::logout();
header('Location: login.php');
exit();
