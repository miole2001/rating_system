<?php
// To display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include '../components/connection.php';

// Handle delete request
if (isset($_POST['delete_user'])) {
    $delete_id = $_POST['delete_id'];

    $verify_delete = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_user = $connForAccounts->prepare("DELETE FROM `rating_accounts` WHERE id = ?");
        $delete_user->execute([$delete_id]);
        $success_msg[] = 'User deleted!';
    } else {
        $warning_msg[] = 'User already deleted!';
    }
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update_user = $connForAccounts->prepare("UPDATE `rating_accounts` SET name = ?, email = ? WHERE id = ?");
    $update_user->execute([$name, $email, $user_id]);
    $success_msg[] = 'User updated successfully!';
}

// Fetch all users
$users = $connForAccounts->query("SELECT * FROM `rating_accounts`")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account List Page</title>

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
            <h6 class="m-0 font-weight-bold text-primary">USER ACCOUNTS DATA</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Picture</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count = 1; // Initialize count before the loop
                        foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $count++; // Increment count after displaying it ?></td>
                            <td><img src="<?php echo '../uploaded_files/' . ($user['image']); ?>" alt="Profile Picture" width="100"></td>
                            <td><?php echo ($user['name']); ?></td>
                            <td><?php echo ($user['email']); ?></td>
                            <td><?php echo ($user['password']); ?></td>
                            <td><?php echo ($user['date_registered']); ?></td>
                            <td>
                                <div class="d-flex justify-content-start">
                                    <button class="btn btn-success btn-sm me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#updateUserModal" 
                                            data-id="<?php echo $user['id']; ?>" 
                                            data-name="<?php echo $user['name']; ?>" 
                                            data-email="<?php echo $user['email']; ?>">Update</button>
                                    <form method="POST" action="" class="delete-form">
                                        <input type="hidden" name="delete_id" value="<?php echo ($user['id']); ?>">
                                        <input type="hidden" name="delete_user" value="1"> <!-- Ensure this is included -->
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Profile Picture</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Update Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="userId">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName" name="name" value="">
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- UPDATE MODAL & DELETE BUTTON CONFIRMATION -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
<script src="../js/admin.js"></script>

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

        // UPDATE MODAL
        $('#updateUserModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget); // Button that triggered the modal
            const userId = button.data('id'); // Extract info from data-* attributes
            const userName = button.data('name');
            const userEmail = button.data('email');

            const modal = $(this);
            modal.find('#userId').val(userId);
            modal.find('#userName').val(userName);
            modal.find('#userEmail').val(userEmail);

            // Debugging logs
            console.log('User ID:', userId);
            console.log('User Name:', userName);
            console.log('User Email:', userEmail);
            console.log('Modal User ID:', modal.find('#userId').val());
            console.log('Modal User Name:', modal.find('#userName').val());
            console.log('Modal User Email:', modal.find('#userEmail').val());
        });
    });
</script>
</body>
</html>
