<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf'] ?? null)) {
    http_response_code(400);
    die('<div class="alert alert-danger m-3">Yêu cầu không hợp lệ (CSRF invalid).</div>');
}

$st = current_student();
$code = $_POST['course_code'] ?? '';
$enrollments = read_json('enrollments.json', []);

// Kiểm tra đã đăng ký
$already = false;
foreach ($enrollments as $e) {
    if ($e['student_code'] === $st['student_code'] && $e['course_code'] === $code) {
        $already = true;
        break;
    }
}

require_once '../includes/header.php'; // header + navbar + flash

if ($already):
    set_flash('info', 'Học phần đã được đăng ký trước đó.');
?>
<div class="alert alert-info mt-3">
    Bạn đã đăng ký học phần này rồi.
    <a href="courses.php" class="btn btn-sm btn-primary ms-2">Quay lại danh sách học phần</a>
</div>
<?php
else:
    // Thêm đăng ký mới
    $enrollments[] = [
        'student_code' => $st['student_code'],
        'course_code' => $code,
        'created_at' => date('Y-m-d H:i:s')
    ];
    write_json('enrollments.json', $enrollments);
    set_flash('success', 'Đăng ký học phần thành công.');
?>
<div class="alert alert-success mt-3">
    Bạn đã đăng ký học phần thành công!
    <a href="registrations.php" class="btn btn-sm btn-success ms-2">Xem học phần đã đăng ký</a>
</div>
<?php
endif;
?>

<a href="courses.php" class="btn btn-secondary mt-3">⬅ Quay lại danh sách học phần</a>

<?php require_once '../includes/footer.php'; ?>
