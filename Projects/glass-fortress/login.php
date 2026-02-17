<?php
include 'includes/header.php'; // Contains DB connection & Session start

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password to match the database (Weak MD5)
    $password_hashed = md5($password);

    // --- VULNERABLE CODE ZONE ---
    // SQL Injection lives here. We are concatenating strings directly.
    // Attacker input: admin' OR '1'='1
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password_hashed'";
    //
    // Execute query
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Set Session Variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // --- VULNERABILITY IMPLANT ---
        // Create a cookie based on role. 
        // If user is admin, value is 1. If user, value is 0.
        $role_text = ($row['role'] == 'admin') ? "role:admin" : "role:user";
        $encoded_cookie = base64_encode($role_text);
        // --- (Using JS to set Cookie) ---
        // PHP setcookie will not work here , so we will use js instead
        echo "<script>
            // Set cookies for one day
            document.cookie = 'auth_token=" . $encoded_cookie . "; path=/; max-age=86400';
            
            //Redirect to main page
            window.location.href = 'index.php';
        </script>";
        exit();
    } else {
        $error_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Invalid Username or Password.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>';
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow mt-5">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Login</h4>
            </div>
            <div class="card-body p-4">

                <?php echo $error_msg; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="username" placeholder="Enter username">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-dark">Access Vault</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                Don't have an account? <a href="register.php">Sign Up</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>