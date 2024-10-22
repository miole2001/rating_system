<?php
// to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// database connection
include 'components/connection.php';

$warning_msg = [];
$success_msg = [];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $_POST['userType'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $c_pass = password_verify($_POST['c_pass'], $pass);
    $image = $_FILES['image']['name'];

    $verify_email = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE email = ?");
    $verify_email->execute([$email]);

    if ($verify_email->rowCount() > 0) {
        $warning_msg[] = 'Email already taken!';
    } else {
        if ($c_pass == 1) {
            $insert_user = $connForAccounts->prepare("INSERT INTO `rating_accounts`(image, name, email, password, userType) VALUES(?,?,?,?,?)");
            $insert_user->execute([$image, $name, $email, $pass, $user_type]);
            $success_msg[] = 'Registered successfully!';
            // Redirect after the alert is shown
            echo '<script>setTimeout(function() { window.location.href = "index.php"; }, 2000);</script>';
        } else {
            $warning_msg[] = 'Confirm password not matched!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- header section starts -->
<header class="header">
    <section class="flex">
        <a href="index.php" class="logo">Rating System</a>
    </section>
</header>
<!-- header section ends -->

<section class="account-form">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Create an Account</h3>
        <p class="placeholder">Your name <span>*</span></p>
        <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="box">

        <p class="placeholder">Your email <span>*</span></p>
        <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="box">

        <p class="placeholder">Your password <span>*</span></p>
        <input type="password" name="pass" required maxlength="50" placeholder="Enter your password" class="box">

        <p class="placeholder">Confirm password <span>*</span></p>
        <input type="password" name="c_pass" required maxlength="50" placeholder="Confirm your password" class="box">

        <p class="placeholder">Profile Picture</p>
        <input type="file" name="image" class="box" accept="image/*">

        <input type="hidden" name="userType" value="rating_user">
        <p class="link">Already have an account? <a href="index.php">Login now</a></p>
        <input type="submit" value="Register now" name="submit" class="btn">
    </form>
</section>

<!-- sweetalert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    // Display alerts if there are messages
    <?php if (!empty($warning_msg)) : ?>
        swal({
            title: "Warning!",
            text: "<?php echo implode("\\n", $warning_msg); ?>",
            icon: "warning",
            button: "Okay",
        });
    <?php endif; ?>

    <?php if (!empty($success_msg)) : ?>
        swal({
            title: "Success!",
            text: "<?php echo implode("\\n", $success_msg); ?>",
            icon: "success",
            button: "Okay",
        });
    <?php endif; ?>
</script>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>
