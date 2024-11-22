<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];

    // Prepare the SQL statement to select the user by email
    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $select_user->execute([$email]);

    // Fetch the user record
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and verify the password
    if ($row && password_verify($pass, $row['password'])) {
        setcookie('user_id', $row['id'], time() + 60 * 60 * 24, '/');
        header('location:home.php');
        exit;
    } else {
        $message[] = 'incorrect email or password'; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>    
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <section>
        <div class="box">
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '
                    <div class="message">
                        <span>' . htmlspecialchars($msg) . '</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>
                    ';
                }
            }
            ?>
            <div class="square" style="--i:0"></div>
            <div class="square" style="--i:1"></div>
            <div class="square" style="--i:2"></div>
            <div class="square" style="--i:3"></div>
            <div class="square" style="--i:4"></div>
            <div class="square" style="--i:5"></div>

            <div class="container">
                <div class="form">
                    <h2>Login Now</h2>
                    <form action="" method="post">
                        <div class="inputBx">
                            <label>User Email</label>
                            <input type="email" name="email" maxlength="50" required>
                        </div>
                        <div class="inputBx">
                            <label>User Password</label>
                            <input type="password" name="pass" maxlength="50" required>
                        </div>
                        <input type="submit" name="submit" value="Login Now" class="btn">
                    </form>
                    <p>Don't have an account? <a href="register.php">Register now</a></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
