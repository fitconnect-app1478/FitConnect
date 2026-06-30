<?php

include 'config.php';

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT fullname,email,created_at FROM users WHERE id=?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-body">

<h2>My Profile</h2>

<hr>

<p><strong>Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>

<p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

<p><strong>Member Since:</strong> <?php echo $user['created_at']; ?></p>

<a href="dashboard.php" class="btn btn-success">
Back to Dashboard
</a>

</div>

</div>

</div>

</div>

</div>

<?php
include 'includes/footer.php';
?>