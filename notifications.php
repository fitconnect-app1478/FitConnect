<?php

include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include 'includes/navbar.php';

// Get notifications
$stmt = $conn->prepare("
SELECT *
FROM notifications
WHERE user_id = ?
ORDER BY created_at DESC
");

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

$notifications = $stmt->get_result();

// Mark all notifications as read
$update = $conn->prepare("
UPDATE notifications
SET is_read = 1
WHERE user_id = ?
");

$update->bind_param("i", $_SESSION['user_id']);
$update->execute();

?>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="text-success">
<i class="fa-solid fa-bell"></i>
Notifications
</h2>

<a href="dashboard.php" class="btn btn-secondary">
<i class="fa-solid fa-arrow-left"></i>
Back
</a>

</div>

<?php if($notifications->num_rows > 0){ ?>

    <?php while($note = $notifications->fetch_assoc()){ ?>

    <div class="card shadow-sm border-0 rounded-4 mb-3">

        <div class="card-body">

            <h5>

                <?php echo htmlspecialchars($note['title']); ?>

            </h5>

            <p>

                <?php echo htmlspecialchars($note['message']); ?>

            </p>

            <small class="text-muted">

                <i class="fa-solid fa-clock"></i>

                <?php echo date(
                    "d M Y, h:i A",
                    strtotime($note['created_at'])
                ); ?>

            </small>

        </div>

    </div>

    <?php } ?>

<?php } else { ?>

<div class="alert alert-info">

<i class="fa-solid fa-circle-info"></i>

No notifications available.

</div>

<?php } ?>

</div>

<?php include 'includes/footer.php'; ?>