<?php
// To display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include '../components/connection.php';

// Handle delete request
if (isset($_POST['delete_review'])) {
    $delete_id = $_POST['delete_id'];

    $verify_delete = $connForPosts->prepare("SELECT * FROM `rating_reviews` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_review = $connForPosts->prepare("DELETE FROM `rating_reviews` WHERE id = ?");
        if ($delete_review->execute([$delete_id])) {
            $success_msg[] = 'Review deleted!';
        } else {
            $error_msg[] = 'Error deleting review.';
        }
    } else {
        $warning_msg[] = 'Review already deleted!';
    }
}

// Fetch all reviews
$reviews = $connForPosts->query("SELECT * FROM `rating_reviews`")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reviews Page</title>

    <!-- DATA TABLE CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.css">

    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/admin.css">

    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    
    <!-- SWEETALERT2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<!-- SIDEBAR INCLUDE -->
<?php include 'sidebar.php'; ?>

<main class="main">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">REVIEWS DATA</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post ID</th>
                            <th>User ID</th>
                            <th>Rate</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date review</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($reviews as $review):
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo ($review['post_id']); ?></td>
                            <td><?php echo ($review['user_id']); ?></td>
                            <td><?php echo ($review['rating'] . "\t star(s)"); ?></td>
                            <td><?php echo ($review['title']); ?></td>
                            <td><?php echo ($review['description']); ?></td>
                            <td><?php echo ($review['date']); ?></td>
                            <td>
                                <form method="POST" action="" class="delete-form">
                                    <input type="hidden" name="delete_id" value="<?php echo ($review['id']); ?>">
                                    <input type="hidden" name="delete_review" value="1">
                                    <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Post ID</th>
                            <th>User ID</th>
                            <th>Rate</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date review</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- DATA TABLE CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>



    <!-- ADMIN.JS SCRIPT DIRECTORY -->
    <script src="../js/admin.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        // Delete confirmation
        $('.delete-btn').on('click', function() {
            const form = $(this).closest('.delete-form');
            const reviewId = form.find('input[name="delete_id"]').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Deleting review ID: " + reviewId); // Debug log
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>

</body>
</html>
