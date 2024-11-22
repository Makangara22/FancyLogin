<?php
include 'connect.php';
if (isset($_POST['submit'])) {
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $select_user->execute([$email]);

    if ($select_user->rowCount() > 0) {
        $message[] = 'Email already exists';
    } elseif ($pass != $cpass) {
        $message[] = 'Confirm password does not match';
    } else {
        // Hash the password before storing it in the database
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $insert_user = $conn->prepare("INSERT INTO users(name, email, password) VALUES(?,?,?)");
        $insert_user->execute([$name, $email, $hashed_pass]);

        if ($insert_user) {
            // Automatically log in the user after registration
            $fetch_user = $conn->prepare("SELECT * FROM users WHERE email=?");
            $fetch_user->execute([$email]);
            $row = $fetch_user->fetch(PDO::FETCH_ASSOC);
            if ($fetch_user->rowCount() > 0) {
                setcookie('user_id', $row['id'], time() + 60 * 60 * 24, '/');
                header('location:home.php');  
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>    
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
                    <h2>Register Now</h2>
                    <form action="" method="post">
                        <div class="inputBx">
                            <label>User Name</label>
                            <input type="text" name="name" maxlength="20" required>
                        </div>
                        <div class="inputBx">
                            <label>User Email</label>
                            <input type="email" name="email" maxlength="50" required>
                        </div>
                        <div class="inputBx">
                            <label>User Password</label>
                            <input type="password" name="pass" maxlength="50" required>
                        </div>
                        <div class="inputBx">
                            <label>Confirm Password</label>
                            <input type="password" name="cpass" maxlength="20" required>
                        </div> 
                        <input type="submit" name="submit" value="Register Now" class="btn">
                    </form>
                    <p>Already have an account? <a href="login.php">Login now</a></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
