<footer class="bg-dark text-white mt-5">

<div class="container">

<div class="row py-5">

<div class="col-md-6">

<h4>FitConnect</h4>

<p>
Connecting fitness enthusiasts through community events,
running clubs, yoga sessions, hiking adventures and
wellness meetups.
</p>

</div>

<div class="col-md-3">

<h5>Quick Links</h5>

<ul class="list-unstyled">

<?php if(isset($_SESSION['user_id'])) { ?>

<li><a href="dashboard.php" class="footer-link">Dashboard</a></li>

<li><a href="events.php" class="footer-link">Events</a></li>

<li><a href="profile.php" class="footer-link">Profile</a></li>

<li><a href="logout.php" class="footer-link">Logout</a></li>

<?php } else { ?>

<li><a href="index.php" class="footer-link">Home</a></li>

<li><a href="register.php" class="footer-link">Register</a></li>

<li><a href="login.php" class="footer-link">Login</a></li>

<?php } ?>

</ul>

</div>

<div class="col-md-3">

<h5>Contact</h5>

<p>

support@fitconnect.com

</p>

</div>

</div>

</div>

<div class="text-center p-3 bg-black">

© <?php echo date("Y"); ?> FitConnect. All Rights Reserved.

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/script.js"></script>

<?php include 'includes/flash.php'; ?>

</body>

</html>