<header class="header">

   <section class="flex">

      <a href="all_posts.php" class="logo">Rating System</a>

      <nav class="navbar">
         <a href="all_posts.php" class="far fa-eye"></a>
         <?php if($user_id != ''): ?>
            <div id="user-btn" class="far fa-user"></div>
         <?php endif; ?>
      </nav>

      <?php if($user_id != ''): ?>
      <div class="profile">
         <?php
            $select_profile = $connForAccounts->prepare("SELECT * FROM `rating_accounts` WHERE id = ? LIMIT 1");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <?php if($fetch_profile['image'] != ''): ?>
            <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="" class="image">
         <?php endif; ?>   
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update.php" class="btn">update profile</a>
         <a href="#" class="delete-btn" id="logout-btn">logout</a>
         <?php } ?>
      </div>
      <?php endif; ?>

   </section>

</header>

<!-- SweetAlert CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
document.getElementById('logout-btn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior
    swal({
        title: "Are you sure?",
        text: "Logout from this website?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willLogout) => {
        if (willLogout) {
            window.location.href = "../components/logout.php"; // Redirect to logout
        }
    });
});
</script>
