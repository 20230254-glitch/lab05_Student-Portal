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

// Map course_code -> enrollment status
$registered = [];
foreach ($enrollments as $e) {
    if ($e['student_code'] === $student_code) {
        $registered[$e['course_code']] = true;
    }
}

// Giả lập slot và trạng thái khóa học
foreach ($courses as &$c) {
    $c['slots'] = rand(0, 5); // còn slot
    $c['status'] = ($c['slots'] === 0) ? 'closed' : 'open';
}
unset($c);
?>

<h3>Quản lý học phần</h3>

<div class="mb-3">
  <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm học phần theo tên hoặc mã HP...">
</div>

<table class="table table-striped table-hover" id="coursesTable">
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
    <?php foreach ($courses as $c): 
        $code = $c['course_code'];
        $isRegistered = isset($registered[$code]);
        $statusText = $isRegistered ? 'Đã đăng ký' :
                        ($c['status'] === 'open' ? 'Còn slot' : 'Khóa học kết thúc');
        $statusClass = $isRegistered ? 'badge bg-success' :
                       ($c['status'] === 'open' ? 'badge bg-primary' : 'badge bg-secondary');
    ?>
    <tr>
      <td><?= htmlspecialchars($code) ?></td>
      <td><?= htmlspecialchars($c['course_name']) ?></td>
      <td><?= htmlspecialchars($c['credits']) ?></td>
      <td><span class="<?= $statusClass ?>"><?= $statusText ?></span></td>
      <td>
        <?php if (!$isRegistered && $c['status'] === 'open'): ?>
          <button class="btn btn-success btn-sm registerBtn" data-code="<?= $code ?>" data-name="<?= htmlspecialchars($c['course_name']) ?>">Đăng ký</button>
        <?php elseif ($isRegistered): ?>
          <button class="btn btn-danger btn-sm unregisterBtn" data-code="<?= $code ?>" data-name="<?= htmlspecialchars($c['course_name']) ?>">Hủy</button>
        <?php else: ?>
          <span class="text-muted">Không thể thao tác</span>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="../dashboard.php" class="btn btn-secondary mt-3">⬅ Quay lại Dashboard</a>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="modalForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Xác nhận</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-footer">
          <input type="hidden" name="course_code" id="modalCourseCode">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary" id="modalConfirmBtn">Xác nhận</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Search filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    const val = this.value.toLowerCase();
    document.querySelectorAll('#coursesTable tbody tr').forEach(tr => {
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(val) ? '' : 'none';
    });
});

// Modal xử lý
const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
document.querySelectorAll('.registerBtn, .unregisterBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        const code = this.dataset.code;
        const name = this.dataset.name;
        const action = this.classList.contains('registerBtn') ? 'Đăng ký' : 'Hủy';
        document.getElementById('modalTitle').innerText = `${action} học phần`;
        document.getElementById('modalBody').innerText = `Bạn có chắc muốn ${action.toLowerCase()} học phần "${name}"?`;
        document.getElementById('modalCourseCode').value = code;
        document.getElementById('modalForm').action = action === 'Đăng ký' ? 'register.php' : 'unregister.php';
        confirmModal.show();
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>
