<?php
include 'includes/header.php';
include 'includes/auth_session.php';
include 'includes/functions.php';

$current_user_id = $_SESSION['user_id']; // الشخص الجالس أمام الكمبيوتر
$msg = "";

// 1. تحديد البروفايل المطلوب عرضه
// هل يوجد ID في الرابط؟ (مثل profile.php?id=5)
if (isset($_GET['id'])) {
    $profile_id = $_GET['id']; // سنعرض بيانات هذا الشخص
} else {
    $profile_id = $current_user_id; // سنعرض بياناتي أنا
}

// 2. معالجة تحديث الـ Bio (يسمح فقط لصاحب الحساب)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // حماية: لا تسمح بالتعديل إلا إذا كان البروفايل المعروض هو نفسه صاحب الجلسة
    // (رغم أن الكود يستخدم session مباشرة، إلا أن التوضيح مهم)

    $new_bio = $_POST['bio'];
    $clean_bio_for_sql = $conn->real_escape_string($new_bio);

    // نستخدم current_user_id هنا حصراً لضمان أنك تعدل بياناتك فقط
    $sql = "UPDATE users SET bio = '$clean_bio_for_sql' WHERE id = $current_user_id";

    if ($conn->query($sql) === TRUE) {
        $msg = '<div class="alert alert-success">Profile updated!</div>';
        // تحديث الصفحة لنرى النتيجة
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        $msg = '<div class="alert alert-danger">Error updating profile.</div>';
    }
}

// 3. جلب بيانات المستخدم المطلوب عرضه (Profile ID)
$sql = "SELECT * FROM users WHERE id = $profile_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<div class='container mt-5 alert alert-danger'>User not found!</div>";
    include 'includes/footer.php';
    exit();
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <?php
                    // تغيير العنوان حسب المالك
                    echo ($profile_id == $current_user_id) ? "My Profile" : "User Profile";
                    ?>
                </h4>
                <span class="badge bg-warning text-dark"><?php echo $user['role']; ?></span>
            </div>
            <div class="card-body">

                <?php echo $msg; ?>

                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <img src="public/images/default-avatar.png" class="img-fluid rounded-circle mb-3" style="max-width: 150px;" alt="Avatar">
                        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        <p class="text-muted">ID: <?php echo $user['id']; ?></p>
                    </div>

                    <div class="col-md-8">
                        <div class="mb-4">
                            <h5>About Me:</h5>
                            <div class="p-3 bg-light border rounded">
                                <?php echo clean_input($user['bio']); ?>
                            </div>
                        </div>

                        <hr>

                        <?php if ($profile_id == $current_user_id): ?>
                            <div class="mb-3">
                                <div class="text-center">
                                    <h5>Profile Settings</h5>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBioModal">
                                        <i class="fas fa-edit"></i> Update Bio
                                    </button>
                                </div>
                            </div>

                            <div class="modal fade" id="editBioModal" tabindex="-1" aria-labelledby="editBioModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Your Bio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="profile.php" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Bio:</label>
                                                    <textarea name="bio" class="form-control" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                                                    <div class="form-text text-danger mt-2">
                                                        <i class="fas fa-bug"></i> Tip: Stored XSS Area.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>