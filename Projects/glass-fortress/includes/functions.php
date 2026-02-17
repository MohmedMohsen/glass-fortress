<?php
// Function to clean inputs (contains a Bypass vulnerability)
function clean_input($data)
{
    // The developer believes that removing the <script> tag protects the site.
    // This approach is called "Blacklisting," and it is highly ineffective.
    $bad_words = array("<script>", "</script>", "alert(");
    $clean_data = str_replace($bad_words, "", $data);

    return $clean_data;
}

// Helper function to convert file sizes (for display purposes only)
function format_size($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}


function show_access_denied()
{
    echo '
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card border-danger shadow-lg" style="max-width: 500px; width: 100%;">
            <div class="card-header bg-danger text-white text-center">
                <h4 class="mb-0"><i class="fas fa-exclamation-triangle"></i> SECURITY ALERT</h4>
            </div>
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    <i class="fas fa-user-lock fa-6x text-danger"></i>
                </div>
                <h2 class="text-danger fw-bold">ACCESS DENIED</h2>
                <p class="lead text-muted mt-3">
                    You do not have the required <strong>Admin Privileges</strong> to view this classified area.
                </p>
                
                <div class="alert alert-secondary mt-4 py-2">
                    <small><i class="fas fa-terminal"></i> Incident reported to system logs.</small>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <a href="../index.php" class="btn btn-outline-danger">
                        <i class="fas fa-arrow-left"></i> Return Home
                    </a>
                </div>
            </div>
            <div class="card-footer bg-light text-center text-muted small">
                Error Code: 403_FORBIDDEN
            </div>
        </div>
    </div>
    ';
    include '../includes/footer.php';
    exit();
}
