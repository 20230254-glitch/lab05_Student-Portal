<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf'] ?? null)) {
    http_response_code(400); exit('Bad Request');
}

$st = current_student();
$code = $_POST['course_code'] ?? '';
$grades = read_json('grades.json', []);

foreach ($grades as $g) {
    if ($g['student_code'] === $st['student_code'] && $g['course_code'] === $code) {
        set_flash('error', 'Không thể hủy: học phần đã có điểm');
        header('Location: registrations.php');
        exit;
    }
}

$enrollments = read_json('enrollments.json', []);
$enrollments = array_filter($enrollments, fn($e) => !($e['student_code'] === $st['student_code'] && $e['course_code'] === $code));
write_json('enrollments.json', array_values($enrollments));

set_flash('success', 'Đã hủy học phần');
header('Location: registrations.php');
exit;
