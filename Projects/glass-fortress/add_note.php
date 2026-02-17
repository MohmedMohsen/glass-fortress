<?php
include 'includes/header.php';
include 'includes/auth_session.php';

$msg = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {

        $clean_title = $conn->real_escape_string($title);
        $clean_content = $conn->real_escape_string($content);

        $sql = "INSERT INTO notes (user_id, title, content) VALUES ('$user_id', '$clean_title', '$clean_content')";

        if ($conn->query($sql) === TRUE) {

            echo "<script>window.location.href='my_notes.php';</script>";
            exit();
        } else {
            $msg = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
        }
    } else {
        $msg = '<div class="alert alert-warning">Please fill in all fields.</div>';
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Add New Note</h4>
                </div>
                <div class="card-body">
                    <?php echo $msg; ?>

                    <form action="add_note.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Note Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g., Secret Plan">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="5" required placeholder="Write your note here..."></textarea>
                            <div class="form-text text-muted">HTML tags are allowed (Vulnerable Area).</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Save Note</button>
                            <a href="my_notes.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>