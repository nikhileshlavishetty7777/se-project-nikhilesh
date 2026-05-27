<?php
session_start();
include 'db_connection.php';

// Sanitize inputs
$firstName = htmlspecialchars(trim($_POST['fname']));
$lastName = htmlspecialchars(trim($_POST['lname']));
$email = htmlspecialchars(trim($_POST['email']));
$contact = htmlspecialchars(trim($_POST['contact']));
$rawPassword = $_POST['password'];
$password = password_hash($rawPassword, PASSWORD_DEFAULT); // Secure hash

// Handle profile image
$profileImage = 'default.jpg';
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = $_FILES['profile_pic']['type'];
    $fileTmp = $_FILES['profile_pic']['tmp_name'];
    $fileName = basename($_FILES['profile_pic']['name']);
    $uniqueName = uniqid() . '_' . $fileName;
    $targetDir = 'uploads/';
    $targetFile = $targetDir . $uniqueName;

    if (in_array($fileType, $allowedTypes)) {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        if (move_uploaded_file($fileTmp, $targetFile)) {
            $profileImage = $uniqueName;
        }
    }
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO staff (email, firstName, lastName, contact, password, dateCreated, profile_image)
                        VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?)");
$stmt->bind_param("ssssss", $email, $firstName, $lastName, $contact, $password, $profileImage);

if ($stmt->execute()) {
    echo "<script>alert('✅ Profile saved successfully!'); window.location.href='profile_setting.html';</script>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>