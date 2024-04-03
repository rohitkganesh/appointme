<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username'])) {
        $username_error = '*Username cannot be empty !';
    } else if (strlen($_POST['username']) < 6 || strlen($_POST['username']) > 20) {
        $username_error = '*Username must be at least 6 characters long to max 20 characters !';
    } else if (!preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['username'])) {
        $username_error = '*Username can only contain letters, numbers and white spaces';
    } else $username_error = '';

}
// --- not completed yet