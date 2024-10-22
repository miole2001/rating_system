<?php
// to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// database connection
include '../components/connection.php';

$success_msg = [];
$warning_msg = [];

if (isset($_POST['submit'])) {
    $select_user = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update name
    if (!empty($name)) {
        $update_name = $connForAccounts->prepare("UPDATE `rating_accounts` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $success_msg[] = 'Username updated!';
    }

    // Update email
    if (!empty($email)) {
        $verify_email = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE email = ?");
        $verify_email->execute([$email]);
        if ($verify_email->rowCount() > 0) {
            $warning_msg[] = 'Email already taken!';
        } else {
            $update_email = $connForAccounts->prepare("UPDATE `rating_accounts` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $success_msg[] = 'Email updated!';
        }
    }

    // Update image
    $image = $_FILES['images']['name'];
    if (!empty($image)) {
        $update_image = $connForAccounts->prepare("UPDATE rating_accounts SET image = ? WHERE id = ?");
        $update_image->execute([$image, $user_id]);
        $success_msg[] = 'Image updated!';
    } else {
        $success_msg[] = 'No new image provided, existing image remains.';
    }

    // Password updates
    $prev_pass = $fetch_user['password'];
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $c_pass = $_POST['c_pass'];

    if (!empty($old_pass)) {
        $verify_old_pass = password_verify($old_pass, $prev_pass);
        if ($verify_old_pass) {
            if ($new_pass === $c_pass && !empty($new_pass)) {
                $update_pass = $connForAccounts->prepare("UPDATE `rating_accounts` SET password = ? WHERE id = ?");
                $update_pass->execute([password_hash($new_pass, PASSWORD_DEFAULT), $user_id]);
                $success_msg[] = 'Password updated!';
            } elseif ($new_pass !== $c_pass) {
                $warning_msg[] = 'Confirm password not matched!';
            } else {
                $warning_msg[] = 'Please enter new password!';
            }
        } else {
            $warning_msg[] = 'Old password not matched!';
        }
    }
}

// Handle image deletion via AJAX
if (isset($_POST['delete_image'])) {
    $select_old_pic = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE id = ? LIMIT 1");
    $select_old_pic->execute([$user_id]);
    $fetch_old_pic = $select_old_pic->fetch(PDO::FETCH_ASSOC);

    if ($fetch_old_pic['image'] == '') {
        $warning_msg[] = 'Image already deleted!';
    } else {
        $update_old_pic = $connForAccounts->prepare("UPDATE `rating_accounts` SET image = ? WHERE id = ?");
        $update_old_pic->execute(['', $user_id]);
        if ($fetch_old_pic['image'] != '') {
            unlink('../uploaded_files/' . $fetch_old_pic['image']);
        }
        $success_msg[] = 'Image deleted!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
   
<!-- header section starts  -->
<?php include 'header.php'; ?>
<!-- header section ends -->

<!-- update section starts  -->
<section class="account-form">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Update your profile!</h3>
        <p class="placeholder">Your name</p>
        <input type="text" name="name" maxlength="50" placeholder="<?= $fetch_profile['name']; ?>" class="box">
        <p class="placeholder">Your email</p>
        <input type="email" name="email" maxlength="50" placeholder="<?= $fetch_profile['email']; ?>" class="box">
        <p class="placeholder">Old password</p>
        <input type="password" name="old_pass" maxlength="50" placeholder="Enter your old password" class="box">
        <p class="placeholder">New password</p>
        <input type="password" name="new_pass" maxlength="50" placeholder="Enter your new password" class="box">
        <p class="placeholder">Confirm password</p>
        <input type="password" name="c_pass" maxlength="50" placeholder="Confirm your new password" class="box">
        <?php if ($fetch_profile['image'] != ''): ?>
            <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="" class="image">
            <input type="button" value="Delete image" class="delete-btn" id="delete-image-btn">
        <?php endif; ?>
        <p class="placeholder">Profile pic</p>
        <input type="file" name="images" class="box" accept="image/*">
        <input type="submit" value="Update now" name="submit" class="btn">
    </form>
</section>
<!-- update section ends -->

<!-- SweetAlert CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
document.getElementById('delete-image-btn').onclick = function() {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this image!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // If confirmed, submit the form to delete the image
            var form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = '<input type="hidden" name="delete_image" value="1">';
            document.body.appendChild(form);
            form.submit();
        }
    });
};

<?php if (!empty($success_msg)): ?>
    swal({
        title: "Success!",
        text: "<?php echo implode(', ', $success_msg); ?>",
        icon: "success",
        button: "OK",
    });
<?php endif; ?>

<?php if (!empty($warning_msg)): ?>
    swal({
        title: "Warning!",
        text: "<?php echo implode(', ', $warning_msg); ?>",
        icon: "warning",
        button: "OK",
    });
<?php endif; ?>
</script>

<?php include '../components/alerts.php'; ?>

</body>
</html>
