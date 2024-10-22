<?php
// to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// database connection
include 'components/connection.php';

$warning_msg = []; // Initialize the warning message array

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Prepare SQL statement to fetch user by email
    $verify_user = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE email = ? LIMIT 1");
    $verify_user->execute([$email]);

    if ($verify_user->rowCount() > 0) {
        $fetch = $verify_user->fetch(PDO::FETCH_ASSOC);
        $user_type = $fetch['userType'];
        $action_type = 'Login';

        // Log the attempt
        if ($user_type === 'rating_admin') {
            $log_stmt = $connForLogs->prepare("INSERT INTO admin_logs (email, action_type, userType) VALUES (?, ?, ?)");
            $log_stmt->execute([$email, $action_type, $user_type]);
            setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
            if ($verify_user) {
                header('Location: admin/dashboard.php');
                exit();
            }
        } else if ($user_type === 'rating_user'){
            $log_stmt = $connForLogs->prepare("INSERT INTO user_logs (email, action_type, userType) VALUES (?, ?, ?)");
            $log_stmt->execute([$email, $action_type, $user_type]);
            if ($verify_user) {
                setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
                header('Location: user/all_posts.php');
                exit();
            }
        } else {

        }
            } else {
        $warning_msg[] = 'Incorrect email!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <section class="flex">
        <a href="index.php" class="logo">Rating System</a>
    </section>
</header>

<section class="account-form">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>welcome back!</h3>
        <p class="placeholder">Your email <span>*</span></p>
        <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
        <p class="placeholder">Your password <span>*</span></p>
        <input type="password" name="pass" required maxlength="50" placeholder="enter your password" class="box">
        <p class="link">don't have an account? <a href="register.php">register now</a></p>
        <input type="submit" value="login now" name="submit" class="btn">
    </form>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>

<?php if (!empty($warning_msg)): ?>
    <script>
        swal({
            title: "Error!",
            text: "<?php echo implode(', ', $warning_msg); ?>",
            icon: "error",
            button: "OK",
        });
    </script>
<?php endif; ?>

</body>
</html>
