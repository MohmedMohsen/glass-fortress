<?php
include 'includes/header.php';
include 'includes/auth_session.php';

$user_id = $_SESSION['user_id'];
$msg = "";

// --- PART A: HANDLE ADDING A NEW NOTE ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO notes (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
        if ($conn->query($sql) === TRUE) {
            $msg = '<div class="alert alert-success">Note created successfully!</div>';
        } else {
            $msg = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
        }
    }
}

// --- PART B: LIST YOUR NOTES ---
// We select ONLY notes that belong to YOU (Safe Query)
$sql = "SELECT * FROM notes WHERE user_id = $user_id ORDER BY id DESC";
$result = $conn->query($sql);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> My Notes List</h5>
                </div>
                <div class="card-body">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <div class="list-group">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                                    <a href="note.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark flex-grow-1">
                                        <i class="far fa-file-alt me-2"></i>
                                        <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                                    </a>

                                    <div>
                                        <span class="badge bg-secondary me-2">ID: <?php echo $row['id']; ?></span>

                                        <a href="delete_note.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>

                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">No notes found. Create one!</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-plus"></i> Create Note</h5>
                </div>
                <div class="card-body">
                    <?php echo $msg; ?>
                    <form action="notes.php" method="POST">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Content</label>
                            <textarea name="content" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Save Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>