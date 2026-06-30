<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    if (
        !empty($title) &&
        !empty($description) &&
        !empty($location) &&
        !empty($event_date) &&
        !empty($event_time)
    ) {

        $stmt = $conn->prepare("INSERT INTO events(title,description,location,event_date,event_time,created_by)
        VALUES(?,?,?,?,?,?)");

        $stmt->bind_param(
            "sssssi",
            $title,
            $description,
            $location,
            $event_date,
            $event_time,
            $_SESSION['user_id']
        );

        if ($stmt->execute()) {

    $_SESSION['toast'] = [
        'type' => 'success',
        'message' => 'Event created successfully.'
    ];

    header("Location: events.php");
    exit();

} else {

    $message = "Error creating event.";

}

$stmt->close();

    } else {
        $message = "Please fill all fields.";
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">

<h2>Create Event</h2>

<?php if($message!=""){ ?>

<div class="alert alert-info">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>Event Title</label>

<input
type="text"
name="title"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="description"
class="form-control"
rows="4"
required></textarea>

</div>

<div class="mb-3">

<label>Location</label>

<input
type="text"
name="location"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Date</label>

<input
type="date"
name="event_date"
class="form-control"
min="<?php echo date('Y-m-d'); ?>"
required>

</div>

<div class="mb-3">

<label>Time</label>

<input
type="time"
name="event_time"
class="form-control"
required>

</div>

<button class="btn btn-success">

Create Event

</button>

</form>

</div>

<?php
include 'includes/footer.php';
?>