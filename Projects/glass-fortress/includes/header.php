<?php
include __DIR__ . '/../config/db.php';
// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Glass Fortress</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">
                <i class="fas fa-shield-alt"></i> Glass Fortress
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link btn btn-primary btn-sm text-white ms-2" href="<?php echo BASE_URL; ?>notes.php">Notes</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-primary btn-sm text-white ms-2" href="<?php echo BASE_URL; ?>files.php">Files</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-primary btn-sm text-white ms-2" href="<?php echo BASE_URL; ?>profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white ms-2" href="<?php echo BASE_URL; ?>logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link btn btn-primary btn-sm text-white ms-2" href="<?php echo BASE_URL; ?>login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-primary btn-sm text-white ms-2" href="<?php echo BASE_URL; ?>register.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container main-content">