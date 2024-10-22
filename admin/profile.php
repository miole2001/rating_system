<?php
// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include '../components/connection.php';

$success_msg = [];
$warning_msg = [];

// Fetch user data (Assuming $user_id is defined and valid)
$select_user = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
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
        $update_image = $connForAccounts->prepare("UPDATE `rating_accounts` SET image = ? WHERE id = ?");
        $update_image->execute([$image, $user_id]);
        $success_msg[] = 'Image updated!';
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

// Handle image deletion via AJAX (similar logic as before)
if (isset($_POST['delete_image'])) {
    // Logic for deleting image...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile Page</title>

    <!-- DATA TABLE CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/admin.css">

    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <!-- SWEETALERT2 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>
<body>

<!-- SIDEBAR INCLUDE -->
<?php include 'sidebar.php'; ?>

    <style>
        .main {
            max-width: 600px;
            margin: 0 10px 0 220px;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            top: 60px;
        }
        h3 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: block; /* Make button block-level */
            width: 100%; /* Full width */
            margin-top: 10px;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .img-preview {
            max-width: 100px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<main class="main">

    <h3>Update Profile Information</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="<?= ($fetch_user['name']); ?>" >
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="<?= ($fetch_user['email']); ?>" >
        </div>
        <div class="form-group">
            <label for="old_pass">Old Password</label>
            <input type="password" name="old_pass" placeholder="Enter your old password">
        </div>
        <div class="form-group">
            <label for="new_pass">New Password</label>
            <input type="password" name="new_pass" placeholder="Enter your new password">
        </div>
        <div class="form-group">
            <label for="c_pass">Confirm New Password</label>
            <input type="password" name="c_pass" placeholder="Confirm your new password">
        </div>
        <div class="form-group">
            <label for="images">Profile Picture</label>
            <input type="file" name="images" accept="image/*">
        </div>
        <?php if ($fetch_user['image']): ?>
            <div>
                <img src="../uploaded_files/<?= htmlspecialchars($fetch_user['image']); ?>" alt="Profile Image" class="img-preview">
                <button type="button" class="btn btn-danger" id="delete-image-btn">Delete Image</button>
            </div>
        <?php endif; ?>
        <button type="submit" name="submit" class="btn">Update Profile</button>
    </form>
</main>

        <!-- ADMIN.JS SCRIPT DIRECTORY -->
        <script src="../js/admin.js"></script>


    <!-- SCRIPT FOR DELETING IMAGE  -->
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
</body>
</html>
