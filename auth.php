<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Bắt buộc login
function require_login(): void {
    if (empty($_SESSION['auth'])) {
        header('Location: login.php');
        exit;
    }
}

// Lấy sinh viên hiện tại
function current_student(): array {
    return $_SESSION['student'] ?? [];
}
