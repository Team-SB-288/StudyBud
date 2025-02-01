<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Bud</title>
    <link rel="stylesheet" href="login.css">
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
            <div class="log-txt">
                <h2>Log In</h2>
            </div>
            <form action="validatelogin.php" id="registerForm" method="post" enctype="multipart/form-data">
                <div class="user-details">
                    <input type="text" placeholder="Enter your E-Mail" name="email" id="username" required autofocus>
                    <div class="error" id="emailError"></div>

                    <input type="password" placeholder="Enter your password" name="password" id="password" required>
                    <div class="error" id="passwordError"></div>
                </div>
                <input type="submit" value="Log In">
            </form>
        </div>
    </div>
    <?php
    echo $_SESSION['error'];    
    ?>

</body>

</html>