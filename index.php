<?php
session_start();

require 'config/condb.php';

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/login.css">
    <title>User Login</title>
</head>

<body>
    <div class="div1">
    <?php
        if ($message !== '') {
            echo "<div class='message'>$message</div>";
            echo "<script>
                setTimeout(function() {
                    document.querySelector('.message').style.animation = 'slideOut 1s forwards';
                    setTimeout(function() {
                        document.querySelector('.message').style.display = 'none';
                    }, 1000);
                }, 3000);
                </script>";
        }
    ?>
    <div class="left">
        <div class="line1">
            <a id="icon" href="intro.php">
            <img id="back" src="../icons/back.png" alt="">
            </a>
            <a id="back" href="intro.php">Back</a>
        </div>
        <div class="line2">
            <div class="logo">
                <img src="assets/images/logo.png" alt="">
            </div>
            <div class="text">
                <p>Enriching farmers' livestock, a step forward to the success of our Municipal Agriculture.</p>
            </div>
        </div>
    </div>
    <form action="function/loginfunction.php" method="post">
        <div class="top">
        </div>
        <b>Account Login</b>
        
        <input type="email" id="email" name="email" onfocus="highlightInput('email')" required>
        <span class="email-label">Email</span>

        <input type="password" id="password" name="password" onfocus="highlightInput('password')" required>
        <span class="password-label">Password</span>
        <input type="checkbox" id="toggleCheckbox" onclick="togglePasswordVisibility()">Show password
        
        <a id="forgot" href="#">Forgot Password?</a>
        <br>
        <button type="submit" id="submitLogin" name="submitLogin">LOG IN</button>
        <br>
    </form>
    </div>
</body>
<script>



    function highlightInput(inputType) {
        if (inputType === 'email') {
            document.querySelector('.email-label').classList.add('focused');
        } else if (inputType === 'password') {
            document.querySelector('.password-label').classList.add('focused');
        }
    }

    function resetInput(inputType) {
        if (inputType === 'email') {
            document.querySelector('.email-label').classList.remove('focused');
        } else if (inputType === 'password') {
            document.querySelector('.password-label').classList.remove('focused');
        }
    }




    function togglePasswordVisibility() {
            var passwordField1 = document.getElementById("password");
            var toggleCheckbox = document.getElementById("toggleCheckbox");

            if (toggleCheckbox.checked) {
                passwordField1.type = "text";
            } else {
                passwordField1.type = "password";
            }
        }
</script>
</html>
