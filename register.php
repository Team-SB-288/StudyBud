<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Bud</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="general-files/utility.css">
    <style>        
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="side-bg"></div>
        <div class="main-bg"></div>
    </div>

    <div class="container">
        <div class="left">
            <div class="title">
                <div class="logo">
                    <img src="IMAGE/Left-logo.png" alt="StudyBud" class="logo">
                </div>
                <div class="txt">
                    <h2>Together we grow!</h2>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="reg-txt">
                <h2>Register</h2>
            </div>
            <form id="registerForm" method="post" enctype="multipart/form-data">
                <div class="details">
                    <div class="sel-pfp">
                        <img id="pfp" src="uploads/profile_pictures/default-profile.jpg" width="250px" height="250px" alt="Selected Profile Picture">
                        <input type="file" id="select-pfp" name="pfp" accept="image/*" required>
                        <div class="error" id="fileError"></div>
                    </div>

                    <div class="user-details">
                        <input type="text" placeholder="Name" name="name" id="name" required autofocus>
                        <div class="error" id="nameError"></div>

                        <input type="tel" placeholder="Phone Number" name="phone" id="phone" required pattern="^\d{10}$">
                        <div class="error" id="phoneError"></div>

                        <input type="email" placeholder="Email" name="email" id="email" required>
                        <div class="error" id="emailError"></div>

                        <input type="password" placeholder="Password" name="password" id="password" required>
                        <div class="error" id="passwordError"></div>

                        <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirmPassword" required>
                        <div class="error" id="confirmPasswordError"></div>
                    </div>
                </div>
                <input type="submit" value="Register">
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let profilePicInput = document.getElementById("select-pfp");
            let profilePicImg = document.getElementById("pfp");

            function updateProfilePic() {
                if (profilePicInput.files && profilePicInput.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let img = new Image();
                        img.onload = function() {
                            let canvas = document.createElement('canvas');
                            let ctx = canvas.getContext('2d');
                            let size = Math.min(img.width, img.height);
                            canvas.width = canvas.height = size;
                            ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, size, size);
                            profilePicImg.src = canvas.toDataURL();
                            
                            // Update the file input with the cropped image
                            canvas.toBlob(function(blob) {
                                let file = new File([blob], profilePicInput.files[0].name, { type: 'image/png' });
                                let dataTransfer = new DataTransfer();
                                dataTransfer.items.add(file);
                                profilePicInput.files = dataTransfer.files;
                            }, 'image/png');
                        }
                        img.src = e.target.result;
                    }
                    reader.readAsDataURL(profilePicInput.files[0]);
                }
            }

            if (profilePicInput) {
                profilePicInput.addEventListener('change', updateProfilePic);
            }
        });
    </script>

    <script>
        document.getElementById("registerForm").addEventListener("submit", function (event) {
            let isValid = true;

            // Name validation
            const name = document.getElementById("name").value.trim();
            if (name.length < 3) {
                isValid = false;
                document.getElementById("nameError").innerText = "Name must be at least 3 characters long.";
            } else {
                document.getElementById("nameError").innerText = "";
            }

            // Phone validation
            const phone = document.getElementById("phone").value.trim();
            if (!/^\d{10}$/.test(phone)) {
                isValid = false;
                document.getElementById("phoneError").innerText = "Enter a valid 10-digit phone number.";
            } else {
                document.getElementById("phoneError").innerText = "";
            }

            // Email validation
            const email = document.getElementById("email").value.trim();
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                isValid = false;
                document.getElementById("emailError").innerText = "Enter a valid email address.";
            } else {
                document.getElementById("emailError").innerText = "";
            }

            // Password validation
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            if (password !== confirmPassword) {
                isValid = false;
                document.getElementById("confirmPasswordError").innerText = "Passwords do not match.";
            } else if (password.length < 6) {
                isValid = false;
                document.getElementById("passwordError").innerText = "Password must be at least 6 characters long.";
            } else {
                document.getElementById("passwordError").innerText = "";
                document.getElementById("confirmPasswordError").innerText = "";
            }

            // File validation
            const file = document.getElementById("select-pfp").files[0];
            if (file) {
                const validTypes = ["image/jpeg", "image/png", "image/gif"];
                if (!validTypes.includes(file.type)) {
                    isValid = false;
                    document.getElementById("fileError").innerText = "Only JPG, PNG, and GIF files are allowed.";
                } else {
                    document.getElementById("fileError").innerText = "";
                }
            } else {
                isValid = false;
                document.getElementById("fileError").innerText = "Please select a profile picture.";
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>

</html>

<?php
// PHP server-side validation
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studybud";

$conn = new mysqli($servername, $username, $password, $dbname);

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
