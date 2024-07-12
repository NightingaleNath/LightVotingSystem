<?php
session_start();
include('includes/conn.php');

function login($username, $password) {
    global $conn;

    $password = md5($password); // Hash the password

    // Query staff table
    $adminQuery = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if (!$adminQuery) {
        return array('status' => 'error', 'message' => "Error: " . mysqli_error($conn));
    } else {
        $adminCount = mysqli_num_rows($adminQuery);
        if ($adminCount > 0) {
            $recordsRow = mysqli_fetch_assoc($adminQuery);
            return checkAndSetSession($recordsRow);
        } else {
            // Query customers table
            return array('status' => 'error', 'message' => 'Invalid Details');
        }
    }
}

function checkAndSetSession($adminRecord) {
    // Set session variables and redirect based on user type
    $_SESSION['admin'] = $adminRecord['id'];
    $userType = 'admin';
    return array('status' => 'success', 'message' => 'Successfully logged in as admin', 'role' => $userType);
}

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'save') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $loginResponse = login($username, $password);

        header('Content-Type: application/json'); // Set the content type to JSON
        echo json_encode($loginResponse);
        exit;
    }
}
?>
