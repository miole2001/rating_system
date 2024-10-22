<?php
// To display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include '../../components/connection.php';

// HANDLE DELETE REQUEST
if (isset($_POST['delete_logs'])) {
    $delete_id = $_POST['delete_id'];

    $verify_delete = $connForLogs->prepare("SELECT * FROM `admin_logs` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_logs = $connForLogs->prepare("DELETE FROM `admin_logs` WHERE id = ?");
        if ($delete_logs->execute([$delete_id])) {
            $success_msg[] = 'Log deleted!';
        } else {
            $error_msg[] = 'Error deleting log.';
        }
    } else {
        $warning_msg[] = 'Log already deleted!';
    }
}

// FETCH ALL DATA OF ADMIN LOGS
$admin_logs = $connForLogs->query("SELECT * FROM `admin_logs` WHERE userType = 'rating_admin'")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs Page</title>

    <!-- DATA TABLE CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.css">

    <!-- CSS LINK -->
    <link rel="stylesheet" href="../../css/admin.css">

    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <!-- SWEETALERT2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<!-- INCLUDE SIDEBAR PHP -->
<?php include '../sidebar.php'; ?>

<main class="main">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ADMIN LOGS DATA</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Activity</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $count = 1;
                        foreach ($admin_logs as $logs):
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo ($logs['email']); ?></td>
                        <td><?php echo ($logs['action_type']); ?></td>
                        <td><?php echo ($logs['date']); ?></td>
                        <td>
                            <form method="POST" action="" class="delete-form">
                                <input type="hidden" name="delete_id" value="<?php echo ($logs['id']); ?>">
                                <input type="hidden" name="delete_logs" value="1">
                                <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Activity</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>


<!-- datatable script cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>

<!-- script for sweetalert2 delete button in the data table  -->
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
                    console.log("Deleting log ID: " + reviewId); // Debug log
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>

<script src="../../js/admin.js"></script>
</body>

</html>
