<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/header.php';
require_login();

$student = current_student();
$student_code = $student['student_code'];

$courses = read_json('courses.json');
$enrollments = read_json('enrollments.json');
$schedule = read_json('schedule.json');

// Map course_code -> course info
$courseMap = [];
foreach ($courses as $c) {
    $courseMap[$c['course_code']] = $c;
}

// Lọc chỉ các môn sinh viên đã đăng ký
$myCourses = [];
foreach ($enrollments as $e) {
    if ($e['student_code'] === $student_code) {
        $myCourses[] = $e['course_code'];
    }
}

// Build table data: [day][time_slot] = course info
$table = [];
foreach ($schedule as $s) {
    $code = $s['course_code'];
    if (in_array($code, $myCourses)) {
        $table[$s['day']][$s['time_slot']] = [
            'name' => $courseMap[$code]['course_name'] ?? $code,
            'room' => $s['room']
        ];
    }
}

$days = ['2'=>'Thứ 2','3'=>'Thứ 3','4'=>'Thứ 4','5'=>'Thứ 5','6'=>'Thứ 6'];
$time_slots = ['1','2','3','4','5','6'];
?>

<h3>Lịch học sinh viên</h3>
<table class="table table-bordered text-center">
    <thead class="table-primary">
        <tr>
            <th>Tiết \ Ngày</th>
            <?php foreach ($days as $d): ?>
                <th><?= $d ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($time_slots as $t): ?>
        <tr>
            <td>Tiết <?= $t ?></td>
            <?php foreach ($days as $dNum => $dName): ?>
                <td>
                    <?php if (!empty($table[$dNum][$t])): 
                        $c = $table[$dNum][$t]; ?>
                        <div class="fw-bold"><?= htmlspecialchars($c['name']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($c['room']) ?></small>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="../dashboard.php" class="btn btn-secondary mt-3">⬅ Quay lại Dashboard</a>

<?php require_once '../includes/footer.php'; ?>
