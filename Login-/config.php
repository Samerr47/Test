<?php
// Global bootstrap: sessions + base path
if (session_status() === PHP_SESSION_NONE) { session_start(); }
define('BASE_PATH', __DIR__);
