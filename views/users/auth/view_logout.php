<?php
session_start();
unset($_SESSION['token']);
header('location: ./view_login.php');
