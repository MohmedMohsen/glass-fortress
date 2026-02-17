<?php
// 1. Start Session & Connect to DB
session_start();
require_once 'config/db.php';

// 2. Check if user is logged in (Authentication)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 3. Check if ID exists in URL
if (isset($_GET['id'])) {
    $note_id = $_GET['id'];

    // --- VULNERABILITY: IDOR ---
    // We Delete based on ID only. 
    // We do NOT check "AND user_id = current_user"
    $sql = "DELETE FROM notes WHERE id = $note_id";

    if ($conn->query($sql) === TRUE) {
        // Success: Redirect back to notes list
        header("Location: notes.php?msg=deleted");
        exit();
    } else {
        // Database Error
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // No ID provided? Go back home.
    header("Location: notes.php");
    exit();
}
