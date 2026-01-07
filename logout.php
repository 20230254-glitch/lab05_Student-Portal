<?php
session_start();
require_once 'includes/csrf.php';
require_once 'includes/flash.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['csrf'] ?? null)) {
    session_unset();
    session_destroy();
    set_flash('info', 'Bạn đã đăng xuất.');
    header('Location: login.php');
    exit;
} else {
    http_response_code(400);
    echo 'Bad request';
}
