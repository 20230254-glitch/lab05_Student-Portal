<?php
require_once 'includes/auth.php';
require_login();
$st = current_student();
require_once 'includes/header.php';
?>

<h2 class="mb-4 text-primary">Chào mừng, <?= htmlspecialchars($st['full_name']) ?>!</h2>
<p class="text-secondary">Mã SV: <b><?= htmlspecialchars($st['student_code']) ?></b> | Lớp: <b><?= htmlspecialchars($st['class_name']) ?></b></p>

<div class="row g-4 mt-3">
  <!-- Hồ sơ sinh viên -->
  <div class="col-md-4 col-sm-6">
    <div class="card h-100 shadow-sm border-primary border-2 hover-card">
      <div class="card-body text-center">
        <div class="display-4 mb-2">👤</div>
        <h5 class="card-title mb-2">Hồ sơ sinh viên</h5>
        <p class="card-text text-muted">Xem chi tiết thông tin cá nhân, nơi sinh, số điện thoại, trường học.</p>
        <a href="student/profile.php" class="btn btn-primary btn-sm">Xem chi tiết</a>
      </div>
    </div>
  </div>

  <!-- Học phần -->
  <div class="col-md-4 col-sm-6">
    <div class="card h-100 shadow-sm border-success border-2 hover-card">
      <div class="card-body text-center">
        <div class="display-4 mb-2">📚</div>
        <h5 class="card-title mb-2">Học phần</h5>
        <p class="card-text text-muted">Đăng ký học phần mới hoặc quản lý các học phần hiện tại.</p>
        <a href="student/courses.php" class="btn btn-success btn-sm">Đăng ký</a>
      </div>
    </div>
  </div>

  <!-- Bảng điểm -->
  <div class="col-md-4 col-sm-6">
    <div class="card h-100 shadow-sm border-info border-2 hover-card">
      <div class="card-body text-center">
        <div class="display-4 mb-2">📊</div>
        <h5 class="card-title mb-2">Bảng điểm</h5>
        <p class="card-text text-muted">Xem điểm tổng kết các học phần đã đăng ký.</p>
        <a href="student/grades.php" class="btn btn-info btn-sm">Xem bảng điểm</a>
      </div>
    </div>
  </div>

  <!-- Học phần đã đăng ký -->
  <div class="col-md-4 col-sm-6">
    <div class="card h-100 shadow-sm border-warning border-2 hover-card">
      <div class="card-body text-center">
        <div class="display-4 mb-2">📝</div>
        <h5 class="card-title mb-2">Học phần đã đăng ký</h5>
        <p class="card-text text-muted">Quản lý các học phần đã đăng ký và hủy nếu chưa có điểm.</p>
        <a href="student/registrations.php" class="btn btn-warning btn-sm text-white">Xem</a>
      </div>
    </div>
  </div>

<!-- Lịch học -->
  <div class="col-md-4 col-sm-6">
    <div class="card h-100 shadow-sm border-secondary border-2 hover-card">
      <div class="card-body text-center">
        <div class="display-4 mb-2">📅</div>
        <h5 class="card-title mb-2">Lịch học</h5>
        <p class="card-text text-muted">Xem lịch học tuần, phòng học, tiết học chi tiết.</p>
        <a href="student/schedule.php" class="btn btn-secondary btn-sm text-white">Xem</a>
      </div>
    </div>
  </div>
</div>
  <!-- Logout -->
  <div class="col-md-2 col-sm-6"> 
  <div class="card h-100 shadow-sm border-danger border-2 hover-card">
    <div class="card-body text-center p-2">
      <div class="display-6 mb-1">🚪</div> 
      <h6 class="card-title mb-1">Đăng xuất</h6>
      <form method="post" action="logout.php">
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
        <button class="btn btn-danger btn-sm">Đăng xuất</button>
      </form>
    </div>
  </div>
</div>


<style>
.hover-card:hover {
    transform: translateY(-5px);
    transition: 0.3s;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>

<?php require_once 'includes/footer.php'; ?>
