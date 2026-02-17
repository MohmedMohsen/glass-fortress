<?php

include 'includes/header.php';
?>

<div class="row justify-content-center text-center">
    <div class="col-lg-8">
        <div class="p-5 hero-card">

            <h1 class="display-4 fw-bold text-dark mb-3">The Glass Fortress</h1>

            <p class="lead text-muted mb-4">
                Internal secure file sharing system. <br>
                <span class="text-danger fs-6 fw-bold"><i class="fas fa-exclamation-triangle"></i> Warning: Insecure Environment</span>
            </p>

            <hr class="my-4">

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="alert alert-success shadow-sm">
                    <h4 class="alert-heading">Welcome back!</h4>
                    <p class="mb-0">You are logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.</p>
                </div>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                    <a href="files.php" class="btn btn-success btn-lg px-4 gap-3">
                        <i class="fas fa-folder-open"></i> Access Vault
                    </a>
                </div>
            <?php else: ?>
                <p class="mb-4">Please login to access company documents.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="register.php" class="btn btn-primary btn-lg px-4 gap-3">Get Started</a>
                    <a href="login.php" class="btn btn-outline-secondary btn-lg px-4">Login</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>