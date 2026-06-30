<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">

<div class="card shadow p-5">

<h2>

Welcome,

<?php echo htmlspecialchars($_SESSION['fullname']); ?>

🎉

</h2>

<p>

You have successfully logged into FitConnect.

</p>

<p>

Dashboard features will be added in Sprint 2.

</p>

<a href="logout.php" class="btn btn-danger">

Logout

</a>

</div>

</div>

<?php
include 'includes/footer.php';
?>