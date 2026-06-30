<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {

            $_SESSION['toast'] = [
              'type' => 'warning',
              'message' => 'Please enter email and password.'
            ];

            header("Location: login.php");
            exit();

    } else {

        $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];

                header("Location: dashboard.php");
                exit();

            } else {

            $_SESSION['toast'] = [
               'type' => 'danger',
               'message' => 'Incorrect password.'
            ];

            header("Location: login.php");
            exit();

            }

        } else {

            $_SESSION['toast'] = [
               'type' => 'danger',
               'message' => 'Email not found.'
            ];
            
            header("Location: login.php");
            exit();

        }

        $stmt->close();
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow-lg rounded-4">

<div class="card-body p-5">

<h2 class="text-center mb-4">

Login

</h2>

<form method="POST">

<div class="mb-3">

<label>Email Address</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-4">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-success w-100">

Login

</button>

</form>

<hr>

<p class="text-center">

Don't have an account?

<a href="register.php">

Register Here

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