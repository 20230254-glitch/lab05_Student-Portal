<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/header.php';
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

// Lấy danh sách học phần đã đăng ký
$myCourses = [];
foreach ($enrollments as $e) {
    if ($e['student_code'] === $student_code) {
        $myCourses[] = $e['course_code'];
    }
}

// Chuẩn bị dữ liệu cho bảng + chart
$labels = [];
$totals = [];
$midterms = [];
$finals = [];

foreach ($myCourses as $code) {
    $g = null;
    foreach ($grades as $gr) {
        if ($gr['student_code'] === $student_code && $gr['course_code'] === $code) {
            $g = $gr;
            break;
        }
    }
    $labels[] = htmlspecialchars($courseMap[$code]['course_name'] ?? $code);
    $totals[] = $g['total'] ?? 0;
    $midterms[] = $g['midterm'] ?? 0;
    $finals[] = $g['final'] ?? 0;
}
?>

<h3>Bảng điểm</h3>

<table class="table table-striped table-hover">
  <thead class="table-primary">
    <tr>
      <th>Học phần</th>
      <th>Điểm giữa kỳ</th>
      <th>Điểm cuối kỳ</th>
      <th>Tổng</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($myCourses as $i => $code): ?>
    <tr>
      <td><?= $labels[$i] ?></td>
      <td><?= $midterms[$i] ?></td>
      <td><?= $finals[$i] ?></td>
      <td><?= $totals[$i] ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h3 class="mt-4">Biểu đồ điểm</h3>
<canvas id="gradesChart" style="max-width: 700px;"></canvas>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('gradesChart').getContext('2d');
const gradesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            {
                label: 'Điểm giữa kỳ',
                data: <?= json_encode($midterms) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            },
            {
                label: 'Điểm cuối kỳ',
                data: <?= json_encode($finals) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.7)'
            },
            {
                label: 'Tổng',
                data: <?= json_encode($totals) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Biểu đồ điểm sinh viên' }
        },
        scales: {
            y: { beginAtZero: true, max: 10 }
        }
    }
});
</script>

<a href="../dashboard.php" class="btn btn-secondary mt-3">⬅ Quay lại Dashboard</a>

<?php require_once '../includes/footer.php'; ?>
