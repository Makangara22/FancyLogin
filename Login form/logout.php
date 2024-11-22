<?php
include 'connect.php';

setcookie('user_id', '', time() - 1, '/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>    
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
                <div class="content">
                    <div class="box">
                        <h3>logged out successfully!</h3>
                        <div class="flex btn">
                            <a href="login.php" class="btn">Login Now</a>
                            <a href="register.php" class="btn">Register Now</a>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
            