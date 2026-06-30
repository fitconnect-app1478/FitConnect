<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include 'includes/navbar.php';

// Get all events
$sql = "SELECT events.*, users.fullname
        FROM events
        JOIN users ON events.created_by = users.id
        ORDER BY event_date ASC, event_time ASC";

$result = $conn->query($sql);
?>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Fitness Events</h2>

<a href="create_event.php" class="btn btn-success">
    <i class="fa-solid fa-plus"></i> Create Event
</a>

</div>

<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success">
    Event created successfully.
</div>

<?php } ?>

<?php if(isset($_GET['updated'])){ ?>

<div class="alert alert-success">
    Event updated successfully.
</div>

<?php } ?>

<div class="row">

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<div class="col-md-6 mb-4">

<div class="card shadow h-100">

<div class="card-body">

<h4>

<?php echo htmlspecialchars($row['title']); ?>

</h4>

<p>

<?php echo nl2br(htmlspecialchars($row['description'])); ?>

</p>

<hr>

<p>

<strong>Location:</strong>

<?php echo htmlspecialchars($row['location']); ?>

</p>

<p>

<strong>Date:</strong>

<?php echo date("d/m/Y", strtotime($row['event_date'])); ?>

</p>

<p>

<strong>Time:</strong>

<?php echo date("h:i A", strtotime($row['event_time'])); ?>

</p>

<p>

<strong>Created By:</strong>

<?php echo htmlspecialchars($row['fullname']); ?>

</p>

<div class="mt-3">

<a
href="event_details.php?id=<?php echo $row['event_id']; ?>"
class="btn btn-primary btn-sm">

View

</a>

<?php

if($_SESSION['user_id']==$row['created_by']){

?>

<a
href="edit_event.php?id=<?php echo $row['event_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete_event.php?id=<?php echo $row['event_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this event?');">

Delete

</a>

<?php

}

?>

</div>

</div>

</div>

</div>

<?php

}

}else{

?>

<div class="alert alert-info">

No events found.

</div>

<?php

}

?>

</div>

</div>

<?php
include 'includes/footer.php';
?>