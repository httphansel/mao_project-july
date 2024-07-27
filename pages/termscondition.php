<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/logo.png">
    <title>MAO2024 Terms and Condition</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .background-container {
            position: relative;
            width: 100%;
            min-height: 100vh; /* Changed to min-height to ensure content pushes the container */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .blurry-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('../assets/images/bg.jpg');
            background-size: cover;
            filter: blur(12px);
            z-index: -1;
        }

        .content {
            z-index: 1;
            padding: 15px;
            color: white;
            text-align: center;
            max-width: 800px;
            margin: auto;
        }

        .content h1 {
            font-size: 3rem;
            color: green;
        }

        .content p {
            font-size: 1.3rem;
            margin-bottom: 0px;
        }

        .logos {
            display: flex;
            justify-content: space-around;
            width: 100%;
            max-width: 800px;
            margin-top: 40px;
        }

        .logos img {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="background-container">
        <div class="blurry-background"></div>
        <div class="content">
            <h1>MAO Terms and Conditions</h1>
            <p>Welcome to crops and livestock management system (CALIMS). These are the terms and conditions by accessing
                our system and using our services. The user must read the terms and conditions of our system carefully.
                <br><br> Acceptance of Terms<br> By having access to our System CALIMS, you agree to these Terms and
                conditions and our Privacy Policy. Note if you do not agree with these terms, you must not use this
                system CALIMS. <br><br> Use of the system<br> <br> Eligibility<br> For using the system you must be
                working in Municipality Agricultural Office (MAO). Using the system CALIMS you must meet the
                requirements working in MAO. <br><br> User Account<br> By having an access certain features of our
                System CALIMS, you may need to create an account. You are responsible for maintaining the
                confidentiality of your account information and for all activities that occur under your account. </p>
        </div>
        <div class="logos">
            <img src="../assets/images/mao.jpg" alt="Logo 2" style="border-radius: 50%;">
            <img src="../assets/images/mao_logo.png" alt="Logo 1">
            <img src="../assets/images/si.jpg" alt="Logo 3" style="border-radius: 50%;">
        </div>
    </div>
</body>

</html>
