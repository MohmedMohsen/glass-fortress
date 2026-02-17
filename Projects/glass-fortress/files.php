<?php
include 'includes/header.php';
include 'includes/auth_session.php'; // Ensure user is logged in
$msg = "";

// --- 1. HANDLE FILE DELETION (THE NEW VULNERABLE FEATURE) ---
if (isset($_POST['delete_file'])) {
    $file_to_delete = $_POST['delete_file'];

    // VULNERABILITY #3: Arbitrary File Deletion / Path Traversal
    // 1. We are NOT checking the Database to see if the current user owns this file.
    // 2. We are using the filename directly from POST. 
    // Attacker can send: "other_user_file.jpg" or "../index.php"

    $file_path = "uploads/" . $file_to_delete;

    if (file_exists($file_path)) {
        // Delete from Storage
        unlink($file_path);

        // Delete from Database (Based on filename, not ID!)
        $clean_name = $conn->real_escape_string($file_to_delete);
        $sql_delete = "DELETE FROM uploads WHERE filename = '$clean_name'";
        $conn->query($sql_delete);

        $msg = '<div class="alert alert-warning">File deleted (hopefully it was yours...).</div>';
    } else {
        $msg = '<div class="alert alert-danger">File not found.</div>';
    }
}

// --- 2. HANDLE FILE UPLOAD (EXISTING VULNERABILITY) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    $file_tmp  = $_FILES['file']['tmp_name'];
    $file_error = $_FILES['file']['error'];

    // VULNERABILITY #1: No Extension Validation
    // VULNERABILITY #2: Keeping Original Filename
    $destination = "uploads/" . basename($file_name);

    if ($file_error === 0) {
        if (move_uploaded_file($file_tmp, $destination)) {
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO uploads (user_id, filename) VALUES ('$user_id', '$file_name')";
            if ($conn->query($sql)) {
                $msg = '<div class="alert alert-success">File uploaded successfully!</div>';
            } else {
                $msg = '<div class="alert alert-warning">DB Error: ' . $conn->error . '</div>';
            }
        } else {
            $msg = '<div class="alert alert-danger">Failed to move file.</div>';
        }
    } else {
        $msg = '<div class="alert alert-danger">Upload Error: ' . $file_error . '</div>';
    }
}

// --- 3. FETCH FILES ---
$sql_files = "SELECT * FROM uploads ORDER BY uploaded_at DESC";
$result_files = $conn->query($sql_files);
?>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cloud-upload-alt"></i> Upload to Vault</h5>
            </div>
            <div class="card-body">
                <?php echo $msg; ?>
                <form action="files.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Select File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt"></i> Public Files</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th>Owner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_files->num_rows > 0): ?>
                            <?php while ($row = $result_files->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-file me-2"></i>
                                        <?php echo htmlspecialchars($row['filename']); ?>
                                    </td>
                                    <td>User #<?php echo $row['user_id']; ?></td>
                                    <td>
                                        <a href="uploads/<?php echo $row['filename']; ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-download"></i> View
                                        </a>

                                        <?php if ($_SESSION['user_id'] == $row['user_id']): ?>
                                            <form action="files.php" method="POST" class="d-inline" onsubmit="return confirm('Delete this file?');">
                                                <input type="hidden" name="delete_file" value="<?php echo htmlspecialchars($row['filename']); ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center p-3">No files uploaded.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>