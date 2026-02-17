<?php
include    '../includes/header.php';
include     '../includes/functions.php';

if (!isset($_COOKIE['auth_token'])) {
    show_access_denied();
}

$cookie_value = $_COOKIE['auth_token'];
$decoded_value = base64_decode($cookie_value);


if ($decoded_value !== "role:admin") {
    show_access_denied();
}

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-danger shadow-lg">
                <div class="card-header bg-danger text-white">
                    <h3><i class="fas fa-user-shield"></i> Admin Dashboard</h3>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Welcome, Commander!</h5>
                    <p class="card-text">You have full control over the system.</p>

                    <hr>

                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="p-3 border bg-light rounded">
                                <h3>5</h3>
                                <p>Users Registered</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border bg-light rounded">
                                <h3>12</h3>
                                <p>Files Uploaded</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border bg-light rounded">
                                <h3>$0.00</h3>
                                <p>Revenue (We are broke)</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Dangerous Actions:</h5>
                        <button class="btn btn-outline-danger btn-sm">Delete All Users</button>
                        <button class="btn btn-outline-danger btn-sm">Format Server</button>
                        <div class="p-1 mb-2 bg-light text-muted small">
                            NOTE: Not working btw , just to feel powerful ! 💪
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>