<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">

<div class="container">

<a class="navbar-brand d-flex align-items-center" href="index.php">

    <img
        src="assets/images/logo.png"
        alt="FitConnect Logo"
        width="45"
        height="45"
        class="me-2">

    <span class="fw-bold fs-4 text-white">

        FitConnect

    </span>

</a>

<button class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav ms-auto">

<?php if(isset($_SESSION['user_id'])){ ?>

<li class="nav-item">
<a class="nav-link" href="dashboard.php">
<i class="fa-solid fa-house me-1"></i> Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="events.php">
<i class="fa-solid fa-calendar-days me-1"></i> Events
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="profile.php">
<i class="fa-solid fa-user me-1"></i> Profile
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="notifications.php">
<i class="fa-solid fa-bell me-1"></i> Notifications
</a>
</li>

<li class="nav-item">
<a class="nav-link text-warning" href="logout.php">
<i class="fa-solid fa-right-from-bracket me-1"></i> Logout
</a>
</li>

<?php } else { ?>

<li class="nav-item">
<a class="nav-link" href="index.php">
Home
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="register.php">
Register
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="login.php">
Login
</a>
</li>

<?php } ?>

</ul>

</div>

</div>

</nav>