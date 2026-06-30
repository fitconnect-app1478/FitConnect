<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {

    $_SESSION['toast'] = [
        'type' => 'warning',
        'message' => 'Invalid event.'
    ];

    header("Location: events.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = (int)$_GET['id'];

$check = $conn->prepare("
SELECT *
FROM rsvp
WHERE user_id = ?
AND event_id = ?
");

$check->bind_param("ii",$user_id,$event_id);
$check->execute();

$result = $check->get_result();

if($result->num_rows > 0){

    $row = $result->fetch_assoc();

    if($row['status']=="Joined"){

        $update = $conn->prepare("
        UPDATE rsvp
        SET status='Cancelled'
        WHERE rsvp_id=?
        ");

        $update->bind_param("i",$row['rsvp_id']);
        $update->execute();

        $_SESSION['toast']=[
            'type'=>'info',
            'message'=>'Your RSVP has been cancelled.'
        ];

    }else{

        $update = $conn->prepare("
        UPDATE rsvp
        SET status='Joined'
        WHERE rsvp_id=?
        ");

        $update->bind_param("i",$row['rsvp_id']);
        $update->execute();

        $_SESSION['toast']=[
            'type'=>'success',
            'message'=>'You have joined this event.'
        ];

    }

}else{

    $insert = $conn->prepare("
    INSERT INTO rsvp(user_id,event_id,status)
    VALUES(?,?,'Joined')
    ");

    $insert->bind_param("ii",$user_id,$event_id);
    $insert->execute();

    $_SESSION['toast']=[
        'type'=>'success',
        'message'=>'You have joined this event.'
    ];

}

header("Location:event_details.php?id=".$event_id);
exit();
?>