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

<?php

/*
Total Events Created
*/

$stmt = $conn->prepare("
SELECT COUNT(*) AS total
FROM events
WHERE created_by=?
");

$stmt->bind_param("i",$_SESSION['user_id']);
$stmt->execute();

$myEvents = $stmt->get_result()->fetch_assoc()['total'];


/*
Upcoming Events Joined
*/

$stmt = $conn->prepare("
SELECT COUNT(*) AS total
FROM rsvp
INNER JOIN events
ON rsvp.event_id=events.event_id
WHERE rsvp.user_id=?
AND rsvp.status='Joined'
AND events.event_date>=CURDATE()
");

$stmt->bind_param("i",$_SESSION['user_id']);
$stmt->execute();

$joinedEvents = $stmt->get_result()->fetch_assoc()['total'];

?>

<div class="row mt-4">

<div class="col-md-4">

<div class="card dashboard-card text-center p-4">

<div class="stat-number">

<?php echo $myEvents; ?>

</div>

<h5>

My Events

</h5>

</div>

</div>

<div class="col-md-4">

<div class="card dashboard-card text-center p-4">

<div class="stat-number">

<?php echo $joinedEvents; ?>

</div>

<h5>

Upcoming Sessions

</h5>

</div>

</div>

<div class="col-md-4">

<div class="card dashboard-card text-center p-4">

<div class="stat-number">

0

</div>

<h5>

Notifications

</h5>

</div>

</div>

</div>

<div class="mt-4 mb-4">

    <a href="events.php" class="btn btn-success me-2">

        <i class="fa-solid fa-calendar-days"></i>

        Find Fitness Events

    </a>

    <a href="create_event.php" class="btn btn-primary">

        <i class="fa-solid fa-plus"></i>

        Create Event

    </a>

</div>

<div class="card shadow mt-4">

    <div class="card-body">

        <h4>

            Upcoming Sessions

        </h4>

        <hr>

        <?php

        $stmt = $conn->prepare("
        SELECT events.*
        FROM rsvp
        INNER JOIN events
        ON rsvp.event_id = events.event_id
        WHERE rsvp.user_id = ?
        AND rsvp.status = 'Joined'
        AND events.event_date >= CURDATE()
        ORDER BY events.event_date ASC
        LIMIT 5
        ");

        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();

        $activities = $stmt->get_result();

        if($activities->num_rows > 0){

            while($event = $activities->fetch_assoc()){

        ?>

            <div class="mb-3">

                <h5>

                    <?php echo htmlspecialchars($event['title']); ?>

                </h5>

                <p>

                    <i class="fa-solid fa-calendar"></i>

                    <?php echo date("d/m/Y", strtotime($event['event_date'])); ?>

                    &nbsp;&nbsp;

                    <i class="fa-solid fa-clock"></i>

                    <?php echo date("h:i A", strtotime($event['event_time'])); ?>

                </p>

            </div>

            <hr>

        <?php

            }

        } else {

        ?>

            <p>

                You have not joined any upcoming events.

            </p>

        <?php

        }

        ?>

    </div>

</div>

</div>

</div>

</div>

<?php

include 'includes/footer.php';

?>