
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
    $errors = [];

    // Server-side validation
    if (strlen($name) < 3) $errors[] = "Name must be at least 3 characters long.";
    if (!preg_match("/^\d{10}$/", $phone)) $errors[] = "Invalid phone number.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email address.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters long.";

    // File upload validation
    if ($_FILES["pfp"]["error"] == 0) {
        $target_dir = "uploads/profile_pictures/";
        $fileType = strtolower(pathinfo($_FILES["pfp"]["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $fileType;
        $targetFile = $target_dir . $newFileName;

        if (!in_array($fileType, ["jpg", "jpeg", "png", "gif"])) {
            $errors[] = "Only JPG, PNG, and GIF files are allowed.";
        } else {
            if (!move_uploaded_file($_FILES["pfp"]["tmp_name"], $targetFile)) {
                $errors[] = "Failed to upload profile picture.";
            }
        }
    } else {
        $errors[] = "Profile picture is required.";
    }

    // Insert into database if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, phone_number, password, profile_picture) 
                VALUES ('$name', '$email', '$phone', '$hashed_password', '$targetFile')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        foreach ($errors as $error) {
            echo "<div style='color: red;'>$error</div>";
        }
    }
}

$conn->close();
?>  