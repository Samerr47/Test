<?php
require_once __DIR__ . '/config.php';

define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // عدّل حسب إعداداتك
define('DB_PASS', '');          // عدّل حسب إعداداتك
define('DB_NAME', 'schooldb');  // نفس الاسم في SQL فوق

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    die('DB connection failed: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
