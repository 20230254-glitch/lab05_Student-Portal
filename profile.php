<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/flash.php';
require_login();

// Thêm thông tin bổ sung vào mảng sinh viên (hoặc bạn có thể lưu trong JSON)
$st = current_student();
$st['birth_place'] = 'Ninh Ninh';
$st['phone'] = '0375975005';
$st['university'] = 'Đại học Công nghệ Đông Á';
$st['birth_date'] = '07/02/2005';
?>

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="card mx-auto" style="max-width: 700px;">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Hồ sơ sinh viên</h4>
    </div>
    <div class="card-body">
        <?php if ($msg = get_flash('success')): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = get_flash('info')): ?>
            <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = get_flash('error')): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <table class="table table-borderless">
            <tbody>
                <tr>
                    <th style="width: 35%;">Mã sinh viên:</th>
                    <td><?= htmlspecialchars($st['student_code']) ?></td>
                </tr>
                <tr>
                    <th>Họ và tên:</th>
                    <td><?= htmlspecialchars($st['full_name']) ?></td>
                </tr>
                <tr>
                    <th>Lớp:</th>
                    <td><?= htmlspecialchars($st['class_name']) ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?= htmlspecialchars($st['email']) ?></td>
                </tr>
                <tr>
                    <th>Nơi sinh:</th>
                    <td><?= htmlspecialchars($st['birth_place']) ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    <td><?= htmlspecialchars($st['phone']) ?></td>
                </tr>
                <tr>
                    <th>Trường học:</th>
                    <td><?= htmlspecialchars($st['university']) ?></td>
                </tr>
                <tr>
                    <th>Ngày sinh:</th>
                    <td><?= htmlspecialchars($st['birth_date']) ?></td>
                </tr>
            </tbody>
        </table>

        <a href="../dashboard.php" class="btn btn-secondary mt-3">⬅ Quay lại Dashboard</a>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
