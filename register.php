<?php
include 'config.php';

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validation
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm)) {

        $message = "Please fill in all fields.";
        $messageType = "danger";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Invalid email address.";
        $messageType = "danger";

    } elseif ($password != $confirm) {

        $message = "Passwords do not match.";
        $messageType = "danger";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";
        $messageType = "danger";

    } else {

        // Check duplicate email
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $message = "Email already exists.";
            $messageType = "warning";

        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users(fullname,email,password) VALUES(?,?,?)");
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

            if ($stmt->execute()) {

                $_SESSION['toast'] = [
                   'type' => 'success',
                   'message' => 'Registration successful. Please login.'
                ];

                header("Location: login.php");
                exit();

            } else {

                $message = "Registration failed.";
                $messageType = "danger";

            }

            $stmt->close();
        }

        $check->close();
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow-lg border-0 rounded-4">

<div class="card-body p-5">

<h2 class="text-center mb-4">
Create Account
</h2>

<?php if($message!=""){ ?>

<div class="alert alert-<?php echo $messageType; ?>">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">Full Name</label>

<input
type="text"
name="fullname"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Email Address</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">Confirm Password</label>

<input
type="password"
name="confirm_password"
class="form-control"
required>

</div>

<button
class="btn btn-success w-100">

Register

</button>

</form>

<hr>

<p class="text-center">

Already have an account?

<a href="login.php">

Login Here

</a>

</p>

</div>

</div>

</div>

</div>

</div>

<?php
include 'includes/footer.php';
?>