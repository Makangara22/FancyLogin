<?php
include 'connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header("location:login.php");
    exit; // Added exit to prevent further code execution
}

// Fix the query to select from the correct table and variable
$select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
$select_profile->execute([$user_id]); // Use $user_id with a dollar sign
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

// Check if a profile was fetched
if (!$fetch_profile) {
    header("location:login.php"); // Redirect if no profile found
    exit;
}
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
                        <h3>Welcome: <span><?= htmlspecialchars($fetch_profile['name']); ?></span></h3>
                        <div class="flex btn">
                            <a href="login.php" class="btn">Login Now</a>
                            <a href="register.php" class="btn">Register Now</a>
                        </div>
                        <a href="logout.php" class="delete-btn" onclick="return confirm('Logout from this website?');">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
