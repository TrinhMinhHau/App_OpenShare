<?php
session_start();
unset($_SESSION['token_admin']);
header('location: ./view_login.php');
