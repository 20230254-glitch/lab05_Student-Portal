<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/flash.php';
require_once __DIR__ . '/csrf.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Student Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { padding-top: 80px; background: #f8f9fa; }
    .navbar .nav-link { margin-right: 1rem; }
    .card { margin-bottom: 1rem; }
    table th, table td { vertical-align: middle; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top  hadow">
  <div class="container">
    <a class="navbar-brand" href="/lab05_StudentPortal/dashboard.php">🏠Student Portal</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="/lab05_StudentPortal/student/profile.php">Hồ sơ</a>
        <a class="nav-link" href="/lab05_StudentPortal/student/grades.php">Điểm</a>
        <a class="nav-link" href="/lab05_StudentPortal/student/courses.php">Học phần</a>
        <a class="nav-link" href="/lab05_StudentPortal/student/registrations.php">Đã đăng ký</a>
        <form method="post" action="/lab05_StudentPortal/logout.php" class="d-inline ms-2">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <button class="btn btn-light btn-sm">Đăng xuất</button>
        </form>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-4">
<?php if ($msg = get_flash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($msg = get_flash('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($msg = get_flash('info')): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
