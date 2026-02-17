<?php
include 'includes/header.php';
include 'includes/auth_session.php'; // Ensures user is logged in

// 1. Check if ID exists in URL
if (!isset($_GET['id'])) {
    echo '<div class="container mt-5 alert alert-danger">No Note ID provided!</div>';
    include 'includes/footer.php';
    exit();
}

$note_id = $_GET['id'];

// --- VULNERABILITY (IDOR) ---
// We select the note by ID only.
// We MISSING the check: "AND user_id = $_SESSION['user_id']"
$sql = "SELECT * FROM notes WHERE id = $note_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $note = $result->fetch_assoc();
} else {
    echo '<div class="container mt-5 alert alert-warning">Note not found.</div>';
    include 'includes/footer.php';
    exit();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark d-flex justify-content-between">
                    <strong><i class="fas fa-eye"></i> Viewing Note #<?php echo $note['id']; ?></strong>
                    <span class="badge bg-dark text-white">Owner ID: <?php echo $note['user_id']; ?></span>
                </div>
                <div class="card-body">
                    <h2 class="card-title text-primary"><?php echo htmlspecialchars($note['title']); ?></h2>
                    <hr>
                    <p class="card-text lead">
                        <?php echo nl2br(htmlspecialchars($note['content'])); ?>
                    </p>
                </div>
                <div class="card-footer text-center">
                    <a href="notes.php" class="btn btn-outline-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>