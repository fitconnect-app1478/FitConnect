<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$event_id = (int)$_GET['id'];

$stmt = $conn->prepare("
SELECT events.*, users.fullname
FROM events
INNER JOIN users
ON events.created_by = users.id
WHERE event_id=?
");

$stmt->bind_param("i",$event_id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){

    $_SESSION['toast']=[
        'type'=>'warning',
        'message'=>'Event not found.'
    ];

    header("Location: events.php");
    exit();
}

$event=$result->fetch_assoc();

$rsvp = $conn->prepare("
SELECT status
FROM rsvp
WHERE user_id=?
AND event_id=?
");

$rsvp->bind_param(
    "ii",
    $_SESSION['user_id'],
    $event_id
);

$rsvp->execute();

$rsvpResult = $rsvp->get_result();

$joined = false;

if($rsvpResult->num_rows>0){

    $status = $rsvpResult->fetch_assoc();

    if($status['status']=="Joined"){
        $joined = true;
    }

}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow border-0 rounded-4">

<div class="card-body">

<h2 class="text-success">

<?php echo htmlspecialchars($event['title']); ?>

</h2>

<hr>

<p>

<strong>Description</strong>

</p>

<p>

<?php echo nl2br(htmlspecialchars($event['description'])); ?>

</p>

<hr>

<p>

<i class="fa-solid fa-location-dot text-danger"></i>

<strong> Location:</strong>

<?php echo htmlspecialchars($event['location']); ?>

</p>

<p>

<i class="fa-solid fa-calendar text-success"></i>

<strong> Date:</strong>

<?php echo date("d/m/Y",strtotime($event['event_date'])); ?>

</p>

<p>

<i class="fa-solid fa-clock text-primary"></i>

<strong> Time:</strong>

<?php echo date("h:i A",strtotime($event['event_time'])); ?>

</p>

<p>

<i class="fa-solid fa-user"></i>

<strong> Organised By:</strong>

<?php echo htmlspecialchars($event['fullname']); ?>

</p>

<hr>

<div class="d-flex gap-2">

<?php if($joined){ ?>

<a
href="rsvp.php?id=<?php echo $event['event_id']; ?>"
class="btn btn-danger">

<i class="fa-solid fa-xmark"></i>

Cancel RSVP

</a>

<?php }else{ ?>

<a
href="rsvp.php?id=<?php echo $event['event_id']; ?>"
class="btn btn-success">

<i class="fa-solid fa-check"></i>

Join Event

</a>

<?php } ?>

<a
href="events.php"
class="btn btn-secondary">

Back

</a>

</div>

</div>

</div>

</div>

</div>

</div>

<?php
include 'includes/footer.php';
?>