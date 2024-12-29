<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/af141631fb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./sign_log.css">
    <script type="text/javascript" src="../core/jquery-3.7.1.min.js"></script>
    <title>Document</title>
</head>

<body>
    <a href="../index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="register_Process.php" id="register_Form" method="post">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" placeholder="Name" id="register_name" name="register_name" />
                <input type="email" placeholder="Email" id="register_email" name="register_email"
                    autocomplete="current-password" required />
                <input type="password" placeholder="Password" id="register_password" name="register_password"
                    autocomplete="current-password" required />
                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form id="login_Form" method="post">
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <input type="email" placeholder="Email" id="email" name="email" autocomplete="current-password"
                    required />
                <input type="password" placeholder="Password" id="password" name="password"
                    autocomplete="current-password" required />
                <a href="#">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./sign_log.js"></script>
    <script type="text/javascript" src="./ajax_process_form.js"></script>
</body>

</html>