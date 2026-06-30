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

// Only allow the event creator to delete
$stmt = $conn->prepare("
    DELETE FROM events
    WHERE event_id = ? AND created_by = ?
");

$stmt->bind_param(
    "ii",
    $event_id,
    $_SESSION['user_id']
);

if ($stmt->execute()) {

    $_SESSION['toast'] = [
    'type' => 'success',
    'message' => 'Event deleted successfully.'
];

    header("Location: events.php");
    exit();

} else {

    header("Location: events.php?error=1");
    exit();

}

?>