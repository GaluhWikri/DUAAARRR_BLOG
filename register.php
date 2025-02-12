<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <header>
        <a href="index.php" style="text-decoration: none; color: inherit;">
        <div class="logo">BOOOOOOOM</div>
        </a>
        <nav>
            <a href="#">ART</a>
            <a href="#">PHOTO</a>
            <a href="#">ILLUSTRATION</a>
        </nav>
    </header>

    <div class="register-container">
        <h2>Register</h2>
        <form>
            <label for="name">Full Name</label>
            <input type="text" id="name" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" required>

            <div class="terms">
                <label for="agree">I agree to the Terms & Conditions</label>
            </div>

            <div class="actions">
                <a href="login.php" class="login-link">Already have an account?</a>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>

    <footer>
        <a href="#">ABOUT</a>
        <a href="#">PRIVACY POLICY</a>
        <a href="#">TERMS & CONDITIONS</a>
        <a href="#">CONTACT</a>
        <a href="#">ADVERTISE!</a>
    </footer>
</body>
</html>
