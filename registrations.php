<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/csrf.php';
require_login();

$student = current_student();
$student_code = $student['student_code'];

// Đọc dữ liệu
$courses = read_json('courses.json');
$enrollments = read_json('enrollments.json');
$grades = read_json('grades.json');

// Map course_code -> course info
$courseMap = [];
foreach ($courses as $c) {
    $courseMap[$c['course_code']] = $c;
}

require_once '../includes/header.php';
?>

<h3>Học phần đã đăng ký</h3>

<table class="table table-bordered table-hover shadow-sm">
  <thead class="table-primary">
    <tr>
      <th>Mã HP</th>
      <th>Tên học phần</th>
      <th>Tín chỉ</th>
      <th>Trạng thái</th>
      <th>Thao tác</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($enrollments as $e): 
        if ($e['student_code'] !== $student_code) continue;
        $code = $e['course_code'];

        // Kiểm tra xem học phần đã có điểm chưa
        $hasGrade = false;
        foreach ($grades as $g) {
            if ($g['student_code'] === $student_code && $g['course_code'] === $code) {
                $hasGrade = true;
                break;
            }
        }
    ?>
    <tr>
      <td><?= htmlspecialchars($code) ?></td>
      <td><?= htmlspecialchars($courseMap[$code]['course_name'] ?? $code) ?></td>
      <td><?= htmlspecialchars($courseMap[$code]['credits'] ?? '-') ?></td>
      <td>
        <?php if ($hasGrade): ?>
          <span class="badge bg-success">Đã có điểm</span>
        <?php else: ?>
          <span class="badge bg-secondary">Chưa có điểm</span>
        <?php endif; ?>
      </td>
      <td>
        <?php if (!$hasGrade): ?>
        <form method="post" action="unregister.php" class="d-inline">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
          <input type="hidden" name="course_code" value="<?= $code ?>">
          <button class="btn btn-danger btn-sm">Hủy</button>
        </form>
        <?php else: ?>
          <button class="btn btn-secondary btn-sm" disabled>Không thể hủy</button>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="../dashboard.php" class="btn btn-secondary mt-3">⬅ Quay lại Dashboard</a>

<?php require_once '../includes/footer.php'; ?>
