<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">

<div class="container">

<a class="navbar-brand fw-bold" href="index.php">

<i class="fa-solid fa-dumbbell"></i>

FitConnect

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
Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="events.php">
Events
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="profile.php">
Profile
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="notifications.php">
Notifications
</a>
</li>

<li class="nav-item">
<a class="nav-link text-warning" href="logout.php">
Logout
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