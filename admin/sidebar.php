<nav class="sidebar">
        <a href="#" class="logo">Rating system</a>
        <div class="menu-content">
        <ul class="menu-items">

    <!-- LINK FOR DASHBOARD -->
    <li class="item">
        <a href="/rating_system/admin/dashboard.php">
            <i class="fa-solid fa-tachometer-alt icon"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>

    <!-- LINK FOR MY PROFILE -->
    <li class="item">
        <a href="/rating_system/admin/profile.php">
            <i class="fa-solid fa-user icon"></i>
            <span class="text">My Profile</span>
        </a>
    </li>

    <!-- LINK FOR ACCOUNT LISTS -->
    <li class="item">
        <a href="/rating_system/admin/accounts.php">
            <i class="fa-solid fa-users icon"></i>
            <span class="text">Account Lists</span>
        </a>
    </li>

    <!-- LINK FOR POSTS -->
    <li class="item">
        <a href="/rating_system/admin/posts.php">
            <i class="fa-solid fa-star icon"></i>
            <span class="text">Posts</span>
        </a>
    </li>

    <!-- LINK FOR REVIEWS -->
    <li class="item">
        <a href="/rating_system/admin/reviews.php">
            <i class="fa-solid fa-star icon"></i>
            <span class="text">Reviews</span>
        </a>
    </li>

    <!-- LINK FOR LOGS -->
    <li class="item">
        <div class="submenu-item">
            <i class="fa-solid fa-history icon"></i>
            <span class="text">Logs</span>
            <i class="fa-solid fa-chevron-right"></i>
        </div>


        <ul class="menu-items submenu">
            <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                <span class="text">All User & Admin Logs</span>
            </div>


            <li class="item">
                <a href="/rating_system/admin/logs/admin_logs.php">
                    <i class="fa-solid fa-user-shield icon"></i>
                    <span class="text">Admin Logs</span>
                </a>
            </li>


            <li class="item">
                <a href="/rating_system/admin/logs/user_logs.php">
                    <i class="fa-solid fa-users icon"></i>
                    <span class="text">User Logs</span>
                </a>
            </li>
        </ul>
    </li>

        
    <li class="item">
        <a href="#" onclick="confirmLogout(event)">
            <i class="fa-solid fa-sign-out-alt icon"></i>
            <span class="text">Logout</span>
        </a>
    </li>

</ul>
        </div>
    </nav>
    <nav class="navbar">
        <i class="fa-solid fa-bars" id="sidebar-close"></i>
    </nav>

<!-- SWEEETALERT2 SCRIPT CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SCRIPT FOR LOGOUT CONFIRMATION  -->
<script>
    function confirmLogout(event) {
        event.preventDefault(); // Prevent default link behavior
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, log me out!',
            cancelButtonText: 'No, stay logged in'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/rating_system/components/logout.php';
            }
        });
    }
</script>
