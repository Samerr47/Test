<?php
require_once __DIR__ . '/config.php';
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
