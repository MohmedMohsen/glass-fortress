<?php
include 'includes/header.php'; // Contains DB connection & Session start

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize inputs simply (Prevents simple SQLi, allows XSS)
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']); // WEAK HASHING (Vulnerability #1)
    $bio = $_POST['bio']; // No escaping here! (Vulnerability #2: Stored XSS)

    // Check if username exists
    $check_query = "SELECT id FROM users WHERE username = '$username'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $message = '<div class="alert alert-danger">Username already taken!</div>';
    } else {
        // Insert User
        $sql = "INSERT INTO users (username, password, bio) VALUES ('$username', '$password', '$bio')";

        if ($conn->query($sql) === TRUE) {
            $message = '<div class="alert alert-success">Registration successful! <a href="login.php" class="alert-link">Login Here</a></div>';
        } else {
            $message = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> Join The Fortress</h4>
            </div>
            <div class="card-body p-4">

                <?php echo $message; ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Choose a username">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Strong password...">
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio (Tell us about you)</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="I am a developer..."></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark">Create Account</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>