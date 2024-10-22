<?php
// To display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include '../components/connection.php';

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $verify_delete = $connForPosts->prepare("SELECT * FROM `rating_posts` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_post = $connForPosts->prepare("DELETE FROM `rating_posts` WHERE id = ?");
        $delete_post->execute([$delete_id]);
        $success_msg[] = 'Post deleted!';
    } else {
        $warning_msg[] = 'Post already deleted!';
    }
}

// Handle add post request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];

    // Insert into the database
    $insert_post = $connForPosts->prepare("INSERT INTO `rating_posts` (title, image) VALUES (?, ?)");
    $insert_post->execute([$title, $image]);
    $success_msg[] = 'Post added successfully!';
}

// Fetch all posts
$posts = $connForPosts->query("SELECT * FROM `rating_posts`")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts Page</title>

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
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">POSTS DATA</h6>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPostModal">Add Post</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Post Image</th>
                            <th>Date posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($posts as $post):
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo ($post['title']); ?></td>
                            <td><?php echo ($post['image']); ?></td>
                            <td><?php echo ($post['date_added']); ?></td>
                            <td>
                                <form method="POST" action="" class="delete-form">
                                    <input type="hidden" name="delete_id" value="<?php echo ($post['id']); ?>">
                                    <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Post Image</th>
                            <th>Date posted</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addPostForm" method="POST" action="" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="postTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Post Image File</label>
                        <input type="file" class="form-control" id="postImage" name="image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DATA TABLE CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>

<!-- AMDIN.JS DIRECTORY -->
<script src="../js/admin.js"></script>





<!-- DELETE CONFIRMATION -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');

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
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });

        // ADD POST CONFIRMATION
        $('#addPostForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to add a new post!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>

</body>
</html>
