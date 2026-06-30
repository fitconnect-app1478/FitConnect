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

// Check ownership
$stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ? AND created_by = ?");
$stmt->bind_param("ii", $event_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: events.php");
    exit();
}

$event = $result->fetch_assoc();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    $update = $conn->prepare("
        UPDATE events
        SET title=?, description=?, location=?, event_date=?, event_time=?
        WHERE event_id=? AND created_by=?
    ");

    $update->bind_param(
        "sssssii",
        $title,
        $description,
        $location,
        $event_date,
        $event_time,
        $event_id,
        $_SESSION['user_id']
    );

    if ($update->execute()) {
        $_SESSION['toast'] = [
        'type' => 'success',
        'message' => 'Event updated successfully.'
        ];

        header("Location: events.php");
        exit();
        
    } else {
        $message = "Unable to update event.";
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">

<h2>Edit Event</h2>

<?php if($message!=""){ ?>
<div class="alert alert-danger">
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
value="<?php echo htmlspecialchars($event['title']); ?>"
required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea
name="description"
class="form-control"
rows="4"
required><?php echo htmlspecialchars($event['description']); ?></textarea>
</div>

<div class="mb-3">
<label>Location</label>
<input
type="text"
name="location"
class="form-control"
value="<?php echo htmlspecialchars($event['location']); ?>"
required>
</div>

<div class="mb-3">
<label>Date</label>
<input
type="date"
name="event_date"
class="form-control"
value="<?php echo $event['event_date']; ?>"
min="<?php echo date('Y-m-d'); ?>"
required>
</div>

<div class="mb-3">
<label>Time</label>
<input
type="time"
name="event_time"
class="form-control"
value="<?php echo $event['event_time']; ?>"
required>
</div>

<button class="btn btn-success">
Update Event
</button>

<a href="events.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

<?php include 'includes/footer.php'; ?>