<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include 'includes/navbar.php';

// Get all events with creator name
$sql = "SELECT events.*, users.fullname
        FROM events
        INNER JOIN users ON events.created_by = users.id
        ORDER BY event_date ASC, event_time ASC";

$result = $conn->query($sql);
?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold text-success">
            <i class="fa-solid fa-calendar-days"></i> Fitness Events
        </h2>

        <a href="create_event.php" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> Create Event
        </a>

    </div>

    <div class="row">

        <?php if($result->num_rows > 0){ ?>

            <?php while($row = $result->fetch_assoc()){ ?>

            <div class="col-lg-6 mb-4">

                <div class="card shadow border-0 rounded-4 h-100">

                    <div class="card-body">

                        <h4 class="text-success fw-bold">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </h4>

                        <p class="text-muted">
                            <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                        </p>

                        <hr>

                        <p>
                            <i class="fa-solid fa-location-dot text-danger"></i>
                            <strong>Location:</strong>
                            <?php echo htmlspecialchars($row['location']); ?>
                        </p>

                        <p>
                            <i class="fa-solid fa-calendar text-success"></i>
                            <strong>Date:</strong>
                            <?php echo date("d/m/Y", strtotime($row['event_date'])); ?>
                        </p>

                        <p>
                            <i class="fa-solid fa-clock text-primary"></i>
                            <strong>Time:</strong>
                            <?php echo date("h:i A", strtotime($row['event_time'])); ?>
                        </p>

                        <p>
                            <i class="fa-solid fa-user text-secondary"></i>
                            <strong>Created By:</strong>
                            <?php echo htmlspecialchars($row['fullname']); ?>
                        </p>

                        <div class="mt-4">

                            <a href="event_details.php?id=<?php echo $row['event_id']; ?>"
                               class="btn btn-primary btn-sm">

                                <i class="fa-solid fa-eye"></i>
                                View

                            </a>

                            <?php if($_SESSION['user_id'] == $row['created_by']){ ?>

                                <a href="edit_event.php?id=<?php echo $row['event_id']; ?>"
                                   class="btn btn-warning btn-sm">

                                    <i class="fa-solid fa-pen"></i>
                                    Edit

                                </a>

                                <button
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal<?php echo $row['event_id']; ?>">

                                    <i class="fa-solid fa-trash"></i>
                                    Delete

                                </button>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Delete Modal -->

            <div class="modal fade"
                 id="deleteModal<?php echo $row['event_id']; ?>"
                 tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">
                                Delete Event
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <p>

                                Are you sure you want to delete

                                <strong>
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </strong>?

                            </p>

                            <p class="text-danger">

                                This action cannot be undone.

                            </p>

                        </div>

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                                Cancel

                            </button>

                            <a
                                href="delete_event.php?id=<?php echo $row['event_id']; ?>"
                                class="btn btn-danger">

                                Delete Event

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            <?php } ?>

        <?php } else { ?>

            <div class="col-12">

                <div class="alert alert-info text-center">

                    <i class="fa-solid fa-circle-info"></i>

                    No fitness events have been created yet.

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>