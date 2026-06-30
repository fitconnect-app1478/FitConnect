<?php

include 'config.php';

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container-fluid mt-4">

<div class="row">

<div class="col-md-3">

<?php include 'includes/sidebar.php'; ?>

</div>

<div class="col-md-9">

<h2>

Welcome,

<?php echo htmlspecialchars($_SESSION['fullname']); ?>

👋

</h2>

<p>

Manage your fitness activities from your dashboard.

</p>

<div class="row mt-4">

<div class="col-md-4">

<div class="card dashboard-card p-4 text-center">

<div class="stat-number">

0

</div>

<h5>

My Events

</h5>

</div>

</div>

<div class="col-md-4">

<div class="card dashboard-card p-4 text-center">

<div class="stat-number">

0

</div>

<h5>

Upcoming Events

</h5>

</div>

</div>

<div class="col-md-4">

<div class="card dashboard-card p-4 text-center">

<div class="stat-number">

0

</div>

<h5>

Notifications

</h5>

</div>

</div>

</div>

<div class="mt-4">
    <a href="create_event.php" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Create New Event
    </a>
</div>

<div class="card shadow mt-4">
    
</div>

<div class="card-body">

<h4>

Upcoming Activities

</h4>

<hr>

<p>

No upcoming activities yet.

</p>

</div>

</div>

</div>

</div>

</div>

<?php

include 'includes/footer.php';

?>