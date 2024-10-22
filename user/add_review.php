<?php

// to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// database connection
include '../components/connection.php';

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: all_posts.php');
    exit(); // Ensure script stops executing after redirect
}

if (isset($_POST['submit'])) {

    if ($user_id != '') {

        $title = $_POST['title'];
        $description = $_POST['description'];
        $rating = $_POST['rating'];

        $verify_review = $connForPosts->prepare("SELECT * FROM `rating_reviews` WHERE post_id = ? AND user_id = ?");
        $verify_review->execute([$get_id, $user_id]);

        if ($verify_review->rowCount() > 0) {
            $warning_msg[] = 'You already reviewed!';
        } else {
            $add_review = $connForPosts->prepare("INSERT INTO `rating_reviews` (post_id, user_id, rating, title, description) VALUES (?, ?, ?, ?, ?)");
            $add_review->execute([$get_id, $user_id, $rating, $title, $description]);
            $success_msg[] = 'Review added!';
            
            // Redirect to the view post page
            header("Location: view_post.php?get_id=$get_id");
            exit(); // Stop script execution after redirect
        }

    } else {
        header("Location: /rating_system/index.php");
        $warning_msg[] = 'Please login first!';
        exit(); // Stop script execution after redirect
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<!-- header section starts -->
<?php include 'header.php'; ?>
<!-- header section ends -->

<!-- add review section starts -->

<section class="account-form">

    <form action="" method="post">
        <h3>Post Your Review</h3>
        <p class="placeholder">Review Title <span>*</span></p>
        <input type="text" name="title" required maxlength="50" placeholder="Enter review title" class="box">
        <p class="placeholder">Review Description</p>
        <textarea name="description" class="box" placeholder="Enter review description" maxlength="1000" cols="30" rows="10"></textarea>
        <p class="placeholder">Review Rating <span>*</span></p>
        <select name="rating" class="box" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <input type="submit" value="Submit Review" name="submit" class="btn">
        <a href="view_post.php?get_id=<?= $get_id; ?>" class="option-btn">Go Back</a>
    </form>

</section>

<!-- add review section ends -->

<!-- sweetalert cdn link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link -->
<script src="../js/script.js"></script>

<?php include '../components/alerts.php'; ?>

</body>
</html>
