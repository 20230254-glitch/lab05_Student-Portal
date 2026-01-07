<?php
declare(strict_types=1);
session_start();

require_once 'includes/data.php';
require_once 'includes/flash.php';

$students = read_json('students.json', []);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['student_code'] ?? '');
    $pass = $_POST['password'] ?? '';

    $found = null;
    foreach ($students as $s) {
        if ($s['student_code'] === $code) {
            $found = $s;
            break;
        }
    }

    if ($found && password_verify($pass, $found['password_hash'])) {
        $_SESSION['auth'] = true;
        $_SESSION['student'] = $found;
        set_flash('success', 'Đăng nhập thành công!');
        header('Location: student/profile.php');
        exit;
    } else {
        $error = 'Sai mã SV hoặc mật khẩu';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Student Portal - Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(135deg, #667eea, #764ba2);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 400px;
    }
    .login-card h3 {
        margin-bottom: 1.5rem;
        text-align: center;
        color: #333;
    }
    .login-card .btn-primary {
        width: 100%;
    }
</style>
</head>
<body>

<div class="login-card">
    <h3>Đăng nhập</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($msg = get_flash('success')): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <input name="student_code" class="form-control" placeholder="Mã SV" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
        </div>
        <button class="btn btn-primary" type="submit">Đăng nhập</button>
    </form>

    <p class="text-center mt-3 text-muted" style="font-size: 0.9rem;">© <?= date('Y') ?> Student Portal</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
